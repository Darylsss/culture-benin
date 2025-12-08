@extends('layouts.public')

@section('title', 'Paiement - ' . $contenu->titre)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Header -->
            <div class="text-center mb-5">
                <a href="{{ route('contenus.show', $contenu->id_contenu) }}" class="btn btn-outline-primary mb-4">
                    <i class="fas fa-arrow-left"></i> Retour à l'article
                </a>
                <h1 class="h2 fw-bold">Finaliser votre achat</h1>
                <p class="text-muted">Accédez au contenu complet de "{{ Str::limit($contenu->titre, 50) }}"</p>
            </div>

            <!-- Card de paiement -->
            <div class="card border-0 shadow-lg rounded-3 overflow-hidden">
                <div class="card-header bg-gradient-primary text-white py-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-lock fa-2x"></i>
                        </div>
                        <div class="flex-grow-1 ms-4">
                            <h3 class="h4 mb-1">{{ $type === 'article' ? 'Article unique' : 'Abonnement' }}</h3>
                            <p class="mb-0 opacity-75">Paiement sécurisé via FedaPay</p>
                        </div>
                        <div class="flex-shrink-0">
                            <span class="badge bg-white text-primary fs-6 py-2 px-3">
                                {{ number_format($amount, 0, '', ' ') }} XOF
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- Informations de l'article -->
                    <div class="alert alert-light border mb-4">
                        <div class="d-flex">
                            @if($contenu->medias && $contenu->medias->count() > 0)
                            <div class="flex-shrink-0">
                                <img src="{{ asset($contenu->medias->first()->chemin) }}" 
                                     alt="{{ $contenu->titre }}"
                                     class="rounded"
                                     style="width: 80px; height: 80px; object-fit: cover;">
                            </div>
                            @endif
                            <div class="flex-grow-1 ms-3">
                                <h6 class="fw-bold mb-1">{{ $contenu->titre }}</h6>
                                <p class="text-muted small mb-0">
                                    {{ Str::limit(strip_tags($contenu->texte), 100) }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Formulaire de paiement -->
                    <form id="paymentForm" action="{{ route('payment.process', $contenu->id_contenu) }}" method="POST">
                        @csrf
                        <input type="hidden" name="payment_type" value="{{ $type }}">
                        <input type="hidden" name="amount" value="{{ $amount }}">

                        <!-- Méthode de paiement -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Méthode de paiement</label>
                            <div class="row g-3">
                                <!-- MTN Mobile Money -->
                                <div class="col-md-6">
                                    <div class="form-check card-select">
                                        <input class="form-check-input" type="radio" 
                                               name="payment_method" value="mtn" 
                                               id="method_mtn" data-requires-phone="true">
                                        <label class="form-check-label w-100" for="method_mtn">
                                            <div class="d-flex align-items-center p-3 border rounded">
                                                <div class="flex-shrink-0">
                                                    <div class="payment-icon bg-warning text-white rounded-circle p-2">
                                                        <i class="fas fa-mobile-alt"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-1">MTN Mobile Money</h6>
                                                    <p class="text-muted small mb-0">Paiement par mobile</p>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <!-- Moov Money -->
                                <div class="col-md-6">
                                    <div class="form-check card-select">
                                        <input class="form-check-input" type="radio" 
                                               name="payment_method" value="moov" 
                                               id="method_moov" data-requires-phone="true">
                                        <label class="form-check-label w-100" for="method_moov">
                                            <div class="d-flex align-items-center p-3 border rounded">
                                                <div class="flex-shrink-0">
                                                    <div class="payment-icon bg-info text-white rounded-circle p-2">
                                                        <i class="fas fa-phone-alt"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-1">Moov Money</h6>
                                                    <p class="text-muted small mb-0">Paiement par mobile</p>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <!-- Carte Visa -->
                                <div class="col-md-6">
                                    <div class="form-check card-select">
                                        <input class="form-check-input" type="radio" 
                                               name="payment_method" value="visa" 
                                               id="method_visa">
                                        <label class="form-check-label w-100" for="method_visa">
                                            <div class="d-flex align-items-center p-3 border rounded">
                                                <div class="flex-shrink-0">
                                                    <div class="payment-icon bg-primary text-white rounded-circle p-2">
                                                        <i class="fab fa-cc-visa"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-1">Carte Visa</h6>
                                                    <p class="text-muted small mb-0">Paiement par carte</p>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <!-- Mastercard -->
                                <div class="col-md-6">
                                    <div class="form-check card-select">
                                        <input class="form-check-input" type="radio" 
                                               name="payment_method" value="mastercard" 
                                               id="method_mastercard">
                                        <label class="form-check-label w-100" for="method_mastercard">
                                            <div class="d-flex align-items-center p-3 border rounded">
                                                <div class="flex-shrink-0">
                                                    <div class="payment-icon bg-danger text-white rounded-circle p-2">
                                                        <i class="fab fa-cc-mastercard"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-1">Mastercard</h6>
                                                    <p class="text-muted small mb-0">Paiement par carte</p>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div id="paymentMethodError" class="text-danger small mt-2" style="display: none;">
                                Veuillez sélectionner une méthode de paiement
                            </div>
                        </div>

                        <!-- Numéro de téléphone (conditionnel) -->
                        <div id="phoneNumberField" class="mb-4" style="display: none;">
                            <label for="phone_number" class="form-label fw-bold">
                                Numéro de téléphone
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">+229</span>
                                <input type="tel" 
                                       class="form-control" 
                                       id="phone_number" 
                                       name="phone_number"
                                       placeholder="Ex: 97000000"
                                       maxlength="8">
                            </div>
                            <div class="form-text">
                                Entrez votre numéro de téléphone Mobile Money
                            </div>
                            <div id="phoneError" class="text-danger small mt-1" style="display: none;">
                                Veuillez entrer un numéro de téléphone valide
                            </div>
                        </div>

                        <!-- Résumé -->
                        <div class="border rounded p-4 mb-4 bg-light">
                            <h6 class="fw-bold mb-3">Résumé de la commande</h6>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Type:</span>
                                <span class="fw-bold">
                                    {{ $type === 'article' ? 'Article unique' : ($type === 'monthly' ? 'Abonnement mensuel' : 'Abonnement annuel') }}
                                </span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Montant:</span>
                                <span>{{ number_format($amount, 0, '', ' ') }} XOF</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Frais de service:</span>
                                <span>{{ number_format($amount * 0.015, 0, '', ' ') }} XOF</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between fw-bold fs-5">
                                <span>Total à payer:</span>
                                <span class="text-primary">{{ number_format($amount, 0, '', ' ') }} XOF</span>
                            </div>
                        </div>

                        <!-- Bouton de paiement -->
                        <div class="d-grid gap-3">
                            <button type="submit" class="btn btn-primary btn-lg py-3" id="payButton">
                                <i class="fas fa-lock me-2"></i>
                                Payer {{ number_format($amount, 0, '', ' ') }} XOF
                            </button>
                            <div class="text-center">
                                <small class="text-muted">
                                    <i class="fas fa-shield-alt me-1"></i>
                                    Paiement 100% sécurisé via FedaPay
                                </small>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Footer sécurisé -->
                <div class="card-footer bg-light py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            <i class="fas fa-lock me-1"></i>
                            Vos données sont sécurisées
                        </div>
                        <div>
                            <img src="https://fedapay.com/images/logo.svg" alt="FedaPay" height="24">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informations supplémentaires -->
            <div class="mt-4">
                <div class="alert alert-info">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle fa-2x"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="alert-heading">Comment fonctionne le paiement ?</h6>
                            <ul class="mb-0">
                                <li>Pour <strong>Mobile Money</strong>, vous serez redirigé vers une page de paiement</li>
                                <li>Pour <strong>cartes bancaires</strong>, vous serez redirigé vers un portail sécurisé</li>
                                <li>Après paiement, vous aurez un accès immédiat au contenu</li>
                                <li>Un reçu sera envoyé à votre adresse email</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.payment-icon {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}

.card-select .form-check-input {
    position: absolute;
    opacity: 0;
}

.card-select .form-check-input:checked + label > div {
    border-color: var(--primary) !important;
    background-color: rgba(79, 70, 229, 0.05);
    box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.2);
}

.card-select .form-check-input:focus + label > div {
    border-color: var(--primary);
}

.bg-gradient-primary {
    background: linear-gradient(135deg, var(--primary), var(--primary-light));
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Initialisation du formulaire de paiement');
    
    const paymentForm = document.getElementById('paymentForm');
    const phoneField = document.getElementById('phoneNumberField');
    const phoneInput = document.getElementById('phone_number');
    const payButton = document.getElementById('payButton');
    const methodError = document.getElementById('paymentMethodError');
    const phoneError = document.getElementById('phoneError');
    
    let selectedMethod = null;
    
    // ÉTAPE 1: Vérifier le CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        console.error('❌ CSRF token manquant! Vérifiez votre layout.');
        alert('Erreur de configuration. Veuillez contacter le support.');
        return;
    }
    console.log('✅ CSRF token trouvé');
    
    // ÉTAPE 2: Gérer la sélection de la méthode de paiement
    document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
        radio.addEventListener('change', function() {
            selectedMethod = this.value;
            methodError.style.display = 'none';
            
            console.log('Méthode sélectionnée:', selectedMethod);
            
            // Afficher/masquer le champ téléphone
            const requiresPhone = this.dataset.requiresPhone === 'true';
            phoneField.style.display = requiresPhone ? 'block' : 'none';
            phoneInput.required = requiresPhone;
        });
    });
    
    // ÉTAPE 3: Validation du formulaire
    paymentForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        console.log('📝 Soumission du formulaire');
        
        // Validation de la méthode
        if (!selectedMethod) {
            methodError.style.display = 'block';
            console.warn('⚠️ Aucune méthode sélectionnée');
            return;
        }
        
        // Validation du téléphone si nécessaire
        if (selectedMethod === 'mtn' || selectedMethod === 'moov') {
            const phone = phoneInput.value.trim();
            const phoneRegex = /^[0-9]{8}$/;
            
            if (!phone || !phoneRegex.test(phone)) {
                phoneError.style.display = 'block';
                console.warn('⚠️ Numéro de téléphone invalide');
                return;
            }
            phoneError.style.display = 'none';
        }
        
        // Désactiver le bouton
        payButton.disabled = true;
        const originalButtonText = payButton.innerHTML;
        payButton.innerHTML = `
            <span class="spinner-border spinner-border-sm me-2" role="status"></span>
            Traitement en cours...
        `;
        
        try {
            console.log('🌐 Envoi de la requête AJAX...');
            console.log('URL:', this.action);
            
            // Préparer les données du formulaire
            const formData = new FormData(this);
            
            // LOG pour débogage
            console.log('Données envoyées:');
            for (let [key, value] of formData.entries()) {
                console.log(`  ${key}: ${value}`);
            }
            
            // IMPORTANT: Envoyer la requête avec tous les headers nécessaires
            const response = await fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                credentials: 'same-origin' // Important pour les cookies de session
            });
            
            console.log('📡 Réponse reçue:', response.status, response.statusText);
            
            // Vérifier les erreurs HTTP
            if (response.status === 419) {
                throw new Error('Session expirée. Veuillez recharger la page.');
            }
            
            if (!response.ok) {
                const errorText = await response.text();
                console.error('Erreur serveur:', errorText);
                throw new Error(`Erreur ${response.status}: ${response.statusText}`);
            }
            
            // Parser la réponse JSON
            const data = await response.json();
            console.log('✅ Données reçues:', data);
            
            if (data.success) {
                if (data.payment_url) {
                    console.log('🔄 Redirection vers:', data.payment_url);
                    // Rediriger vers le portail de paiement
                    window.location.href = data.payment_url;
                } else {
                    showSuccess(data.message || 'Paiement initié avec succès');
                }
            } else {
                showError(data.message || 'Une erreur est survenue');
                resetButton(originalButtonText);
            }
            
        } catch (error) {
            console.error('❌ Erreur:', error);
            showError(error.message || 'Erreur réseau. Veuillez réessayer.');
            resetButton(originalButtonText);
        }
    });
    
    function resetButton(originalText) {
        payButton.disabled = false;
        payButton.innerHTML = originalText;
    }
    
    function showSuccess(message) {
        alert('✅ ' + message);
    }
    
    function showError(message) {
        alert('❌ ' + message);
    }
    
    console.log('✅ Formulaire prêt');
});
</script>
@endsection