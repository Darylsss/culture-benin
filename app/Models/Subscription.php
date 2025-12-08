<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'payment_id',
        'type',
        'amount',
        'status',
        'start_date',
        'end_date',
        'cancelled_at',
        'features',
    ];

    protected $casts = [
        'features' => 'array',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'cancelled_at' => 'datetime',
        'amount' => 'decimal:2',
    ];

    /**
     * Relations
     */
    public function user()
    {
        // ✅ Relation vers User (clients frontend)
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    /**
     * Annuler l'abonnement
     */
    public function cancel()
    {
        $this->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);
    }

    /**
     * Vérifier si l'abonnement est actif
     */
    public function isActive()
    {
        return $this->status === 'active' 
            && $this->end_date > now();
    }

    /**
     * Vérifier si l'abonnement est expiré
     */
    public function isExpired()
    {
        return $this->end_date <= now();
    }

    /**
     * Renouveler l'abonnement
     */
    public function renew()
    {
        $duration = $this->type === 'monthly' ? 1 : 12;
        
        $this->update([
            'start_date' => now(),
            'end_date' => now()->addMonths($duration),
            'status' => 'active',
        ]);
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where('end_date', '>', now());
    }

    public function scopeExpired($query)
    {
        return $query->where('end_date', '<=', now());
    }

    /**
     * Boot method
     */
    protected static function boot()
    {
        parent::boot();

        // Vérifier automatiquement l'expiration
        static::retrieved(function ($subscription) {
            if ($subscription->status === 'active' && $subscription->isExpired()) {
                $subscription->update(['status' => 'expired']);
            }
        });
    }
}