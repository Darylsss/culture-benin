<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->is_admin === true;
    }
    
    /**
     * ✅ Relations correctes vers payments et subscriptions
     */
    public function payments()
    {
        return $this->hasMany(Payment::class, 'user_id', 'id');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'user_id', 'id');
    }

    /**
     * Vérifie si l'utilisateur a accès à un contenu
     */
    public function hasAccessToContent($contenu)
    {
        // Vérifier si l'utilisateur a payé pour ce contenu spécifique
        $hasPaidForContent = $this->payments()
            ->where('content_id', $contenu->id_contenu)
            ->where('status', 'completed')
            ->exists();

        // Vérifier si l'utilisateur a un abonnement actif
        $hasActiveSubscription = $this->hasActiveSubscription();

        return $hasPaidForContent || $hasActiveSubscription;
    }

    /**
     * Vérifie si l'utilisateur a un abonnement actif
     */
    public function hasActiveSubscription()
    {
        return $this->subscriptions()
            ->where('status', 'active')
            ->where('end_date', '>', now())
            ->exists();
    }

    /**
     * Récupère l'abonnement actif de l'utilisateur
     */
    public function activeSubscription()
    {
        return $this->subscriptions()
            ->where('status', 'active')
            ->where('end_date', '>', now())
            ->first();
    }

    /**
     * Vérifie si l'utilisateur a déjà acheté un contenu spécifique
     */
    public function hasPurchasedContent($contentId)
    {
        return $this->payments()
            ->where('content_id', $contentId)
            ->where('status', 'completed')
            ->exists();
    }
}