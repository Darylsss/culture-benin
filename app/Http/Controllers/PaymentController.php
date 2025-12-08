<?php

namespace App\Http\Controllers;

use App\Models\Contenu;
use App\Models\Payment;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use FedaPay\FedaPay;
use FedaPay\Transaction;
use Carbon\Carbon;

class PaymentController extends Controller
{
    /**
     * Initialiser FedaPay
     */
   private function initFedaPay()
{
    // Vérifier le mode simulation
    if (config('fedapay.simulate', false)) {
        Log::info('Mode simulation FedaPay activé - Pas de connexion réelle');
        return; // Ne pas initialiser FedaPay en mode simulation
    }
    
    $environment = config('fedapay.environment', 'sandbox');
    $config = config("fedapay.{$environment}");
    
    if (empty($config['secret_key'])) {
        throw new \Exception('Clé secrète FedaPay non configurée. Vérifiez votre fichier .env ou activez le mode simulation (FEDAPAY_SIMULATE=true)');
    }
    
    Log::info('Initializing FedaPay', ['environment' => $environment]);
    
    FedaPay::setApiKey($config['secret_key']);
    FedaPay::setEnvironment($environment);
    FedaPay::setVerifySslCerts(app()->environment('production'));
}

    /**
     * Afficher le formulaire de paiement
     */
    public function showPaymentForm(Contenu $contenu, $type = 'article')
    {
        $amounts = config('fedapay.default_amounts');
        
        if (!array_key_exists($type, $amounts)) {
            abort(404, 'Type de paiement non valide');
        }

        $amount = $amounts[$type];
        
        return view('payments.form', compact('contenu', 'type', 'amount'));
    }

    /**
     * Traiter le paiement
     */
    public function processPayment(Request $request, Contenu $contenu)
    {
        $request->validate([
            'payment_type' => 'required|in:article,monthly,annual',
            'payment_method' => 'required|in:mtn,moov,visa,mastercard,wave',
            'phone_number' => 'required_if:payment_method,mtn,moov,wave|string|max:20',
            'amount' => 'required|numeric|min:100',
        ]);

        $user = Auth::user();
        
        if ($user->hasAccessToContent($contenu)) {
            return response()->json([
                'success' => false,
                'message' => 'Vous avez déjà accès à ce contenu'
            ], 400);
        }

        try {
            Log::info('=== DÉBUT PROCESS PAYMENT ===', [
                'user_id' => $user->id,
                'content_id' => $contenu->id_contenu,
                'payment_method' => $request->payment_method,
                'amount' => $request->amount
            ]);
            
            // Mode simulation pour développement local
            if (config('fedapay.simulate', false) && !app()->environment('production')) {
                return $this->simulatePayment($request, $contenu);
            }
            
            // Initialiser FedaPay
            $this->initFedaPay();
            
            // Créer le paiement en base
            $payment = Payment::create([
                'user_id' => $user->id,
                'content_id' => $contenu->id_contenu,
                'payment_type' => $request->payment_type,
                'payment_method' => $request->payment_method,
                'phone_number' => $request->phone_number,
                'amount' => $request->amount,
                'fee' => $this->calculateFee($request->amount),
                'net_amount' => $this->calculateNetAmount($request->amount),
                'currency' => 'XOF',
                'description' => "Achat: {$contenu->titre}",
                'metadata' => [
                    'content_title' => $contenu->titre,
                    'payment_type' => $request->payment_type,
                    'user_email' => $user->email,
                ]
            ]);

            Log::info('Payment created', ['payment_id' => $payment->id]);
            
            // Préparer les données de transaction
            $transactionData = [
                'description' => "Achat: {$contenu->titre}",
                'amount' => (int) $request->amount,
                'currency' => ['iso' => 'XOF'],
                'callback_url' => route('payment.callback'),
                'custom_metadata' => [
                    'payment_id' => $payment->id,
                    'content_id' => $contenu->id_contenu,
                    'user_id' => $user->id,
                ]
            ];
            
            // Ajouter les informations client
            if ($user->email) {
                $transactionData['customer'] = [
                    'email' => $user->email,
                    'lastname' => $user->name ?? 'Client',
                    'firstname' => $user->prenom ?? 'Utilisateur',
                ];
            }
            
            Log::info('Creating FedaPay transaction', $transactionData);
            
            // Créer la transaction FedaPay
            $transaction = Transaction::create($transactionData);
            
            // Vérifier que la transaction a été créée
            if (!$transaction || !isset($transaction->id)) {
                throw new \Exception('Échec de création de la transaction FedaPay');
            }
            
            $transactionId = $transaction->id;
            
            Log::info('Transaction created', [
                'transaction_id' => $transactionId,
                'status' => $transaction->status ?? 'unknown'
            ]);
            
            // Mettre à jour le paiement avec l'ID transaction
            $payment->update([
                'transaction_id' => $transactionId,
                'status' => 'processing'
            ]);

            // Générer le token de paiement
            Log::info('Generating payment token');
            
            $token = $transaction->generateToken();
            
            if (!$token) {
                throw new \Exception('Impossible de générer le token de paiement');
            }
            
            // Récupérer l'URL de paiement (compatible avec différentes versions)
            $paymentUrl = $token->url ?? $token->payment_url ?? null;
            
            if (!$paymentUrl) {
                Log::error('Token structure', ['token' => $token]);
                throw new \Exception('URL de paiement introuvable dans la réponse');
            }
            
            Log::info('Payment URL generated', ['url' => $paymentUrl]);
            
            // Réponse différente selon la méthode
            $isMobileMoney = in_array($request->payment_method, ['mtn', 'moov', 'wave']);
            
            return response()->json([
                'success' => true,
                'message' => $isMobileMoney 
                    ? 'Confirmez le paiement sur votre mobile via le lien' 
                    : 'Redirection vers le portail de paiement',
                'payment_url' => $paymentUrl,
                'payment_id' => $payment->id,
                'transaction_id' => $transactionId,
                'requires_confirmation' => $isMobileMoney
            ]);

        } catch (\Exception $e) {
            Log::error('=== PAYMENT ERROR ===', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Marquer le paiement comme échoué s'il existe
            if (isset($payment)) {
                $payment->update(['status' => 'failed']);
            }
            
            return response()->json([
                'success' => false,
                'message' => app()->environment('local') 
                    ? 'Erreur: ' . $e->getMessage()
                    : 'Une erreur est survenue lors du traitement du paiement'
            ], 500);
        }
    }

    /**
     * Simuler un paiement (développement)
     */
    private function simulatePayment(Request $request, Contenu $contenu)
    {
        Log::info('=== SIMULATION MODE ===');
        
        $user = Auth::user();
        
        $payment = Payment::create([
            'user_id' => $user->id,
            'content_id' => $contenu->id_contenu,
            'payment_type' => $request->payment_type,
            'payment_method' => $request->payment_method,
            'phone_number' => $request->phone_number,
            'amount' => $request->amount,
            'fee' => $this->calculateFee($request->amount),
            'net_amount' => $this->calculateNetAmount($request->amount),
            'currency' => 'XOF',
            'description' => "Achat simulé: {$contenu->titre}",
            'transaction_id' => 'SIM_' . time() . '_' . rand(1000, 9999),
            'status' => 'processing',
        ]);
        
        // Simuler un succès après 3 secondes
        \Illuminate\Support\Facades\Bus::dispatch(function() use ($payment) {
            sleep(3);
            $payment->markAsCompleted();
        });
        
        return response()->json([
            'success' => true,
            'message' => 'Mode simulation activé - Paiement validé automatiquement',
            'payment_url' => route('contenus.show', $contenu->id_contenu),
            'payment_id' => $payment->id,
            'simulation' => true
        ]);
    }

    /**
     * Formater le numéro de téléphone
     */
    private function formatPhoneNumber($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        if (strlen($phone) === 12 && strpos($phone, '229') === 0) {
            return '+' . $phone;
        }
        
        if (strlen($phone) === 8) {
            return '+229' . $phone;
        }
        
        return $phone;
    }

    /**
     * Callback de paiement
     */
    public function paymentCallback(Request $request)
    {
        Log::info('=== PAYMENT CALLBACK ===', $request->all());
        
        $transactionId = $request->input('transaction_id') ?? $request->input('id');
        
        if (!$transactionId) {
            Log::error('Transaction ID manquant dans le callback');
            return redirect()->route('contenus.index')
                ->with('error', 'Erreur: Transaction non identifiée');
        }

        try {
            $this->initFedaPay();
            
            $transaction = Transaction::retrieve($transactionId);
            $payment = Payment::where('transaction_id', $transactionId)->firstOrFail();
            
            Log::info('Callback - Transaction status', [
                'transaction_id' => $transactionId,
                'status' => $transaction->status
            ]);
            
            if ($transaction->status === 'approved') {
                $payment->markAsCompleted();
                
                if (in_array($payment->payment_type, ['monthly', 'annual'])) {
                    $this->createSubscription($payment);
                }
                
                return redirect()->route('contenus.show', $payment->content_id)
                    ->with('success', 'Paiement réussi ! Vous avez accès au contenu.');
            } else {
                $payment->markAsFailed();
                
                return redirect()->route('contenus.show', $payment->content_id)
                    ->with('error', 'Le paiement a échoué. Veuillez réessayer.');
            }

        } catch (\Exception $e) {
            Log::error('Erreur callback', [
                'message' => $e->getMessage(),
                'transaction_id' => $transactionId
            ]);
            
            return redirect()->route('contenus.index')
                ->with('error', 'Erreur lors du traitement du paiement.');
        }
    }

    /**
     * Webhook FedaPay
     */
    public function webhook(Request $request)
    {
        Log::info('=== WEBHOOK RECEIVED ===', $request->all());
        
        $payload = $request->getContent();
        $signature = $request->header('X-FedaPay-Signature');
        
        // Vérifier la signature
        if (!$this->verifyWebhookSignature($payload, $signature)) {
            Log::warning('Signature webhook invalide');
            return response()->json(['error' => 'Signature invalide'], 400);
        }

        $data = json_decode($payload, true);
        
        if (!isset($data['entity']) || !isset($data['entity']['id'])) {
            Log::error('Webhook mal formé', ['data' => $data]);
            return response()->json(['error' => 'Données invalides'], 400);
        }
        
        $event = $data['event'] ?? 'unknown';
        $transactionId = $data['entity']['id'];
        
        Log::info('Processing webhook', [
            'event' => $event,
            'transaction_id' => $transactionId
        ]);

        try {
            $payment = Payment::where('transaction_id', $transactionId)->first();

            if (!$payment) {
                Log::warning('Paiement non trouvé', ['transaction_id' => $transactionId]);
                return response()->json(['status' => 'ignored'], 200);
            }

            switch ($event) {
                case 'transaction.approved':
                    $payment->markAsCompleted();
                    
                    if (in_array($payment->payment_type, ['monthly', 'annual'])) {
                        $this->createSubscription($payment);
                    }
                    break;

                case 'transaction.declined':
                case 'transaction.canceled':
                    $payment->markAsFailed();
                    break;

                case 'transaction.refunded':
                    $payment->update(['status' => 'refunded']);
                    
                    if ($payment->subscription) {
                        $payment->subscription->cancel();
                    }
                    break;
            }

            Log::info('Webhook traité', [
                'payment_id' => $payment->id,
                'status' => $payment->status
            ]);

            return response()->json(['status' => 'success'], 200);

        } catch (\Exception $e) {
            Log::error('Erreur webhook', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Vérifier le statut d'un paiement
     */
    public function checkPaymentStatus($paymentId)
    {
        $payment = Payment::findOrFail($paymentId);
        
        if (!$payment->transaction_id) {
            return response()->json([
                'status' => 'pending',
                'payment_status' => $payment->status,
                'message' => 'Transaction en attente'
            ]);
        }

        try {
            $this->initFedaPay();
            $transaction = Transaction::retrieve($payment->transaction_id);
            
            // Mettre à jour le statut local si nécessaire
            if ($transaction->status === 'approved' && $payment->status !== 'completed') {
                $payment->markAsCompleted();
                
                if (in_array($payment->payment_type, ['monthly', 'annual'])) {
                    $this->createSubscription($payment);
                }
            }
            
            return response()->json([
                'status' => $transaction->status,
                'payment_status' => $payment->status,
                'has_access' => $payment->isPaid(),
                'transaction' => [
                    'id' => $transaction->id,
                    'amount' => $transaction->amount,
                    'currency' => $transaction->currency['iso'] ?? 'XOF',
                    'created_at' => $transaction->created_at ?? null
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur check status', [
                'payment_id' => $paymentId,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'status' => 'error',
                'payment_status' => $payment->status,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Calculer les frais
     */
    private function calculateFee($amount)
    {
        $feePercentage = config('fedapay.transaction_fee', 1.5);
        return ($amount * $feePercentage) / 100;
    }

    /**
     * Calculer le montant net
     */
    private function calculateNetAmount($amount)
    {
        return $amount - $this->calculateFee($amount);
    }

    /**
     * Créer un abonnement
     */
    private function createSubscription(Payment $payment)
    {
        $endDate = $payment->payment_type === 'monthly' 
            ? now()->addMonth() 
            : now()->addYear();

        return Subscription::create([
            'user_id' => $payment->user_id,
            'payment_id' => $payment->id,
            'type' => $payment->payment_type,
            'amount' => $payment->amount,
            'start_date' => now(),
            'end_date' => $endDate,
            'status' => 'active',
            'features' => [
                'access_all_contents' => true,
                'priority_support' => true,
                'no_ads' => true
            ]
        ]);
    }

    /**
     * Vérifier la signature du webhook
     */
    private function verifyWebhookSignature($payload, $signature)
    {
        if (!$signature) {
            Log::warning('Signature manquante dans le webhook');
            return false;
        }
        
        $secret = config('fedapay.webhook_secret');
        
        if (empty($secret)) {
            Log::warning('Webhook secret non configuré - validation ignorée en développement');
            return app()->environment('local'); // Accepter en dev, refuser en prod
        }
        
        $expectedSignature = hash_hmac('sha256', $payload, $secret);
        
        return hash_equals($expectedSignature, $signature);
    }

    /**
     * Historique des paiements
     */
    public function paymentHistory()
    {
        $user = Auth::user();
        $payments = $user->payments()
            ->with('content')
            ->latest()
            ->paginate(10);
        
        return view('payments.history', compact('payments'));
    }
}