<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'transaction_id',
        'user_id',
        'content_id',
        'status',
        'payment_type',
        'payment_method',
        'phone_number',
        'amount',
        'fee',
        'net_amount',
        'currency',
        'description',
        'metadata',
        'paid_at',
    ];

    protected $casts = [
        'metadata' => 'array',
        'paid_at' => 'datetime',
        'amount' => 'decimal:2',
        'fee' => 'decimal:2',
        'net_amount' => 'decimal:2',
    ];

    /**
     * Relations
     */
    public function user()
    {
        // ✅ Relation vers User (clients frontend)
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function content()
    {
        return $this->belongsTo(Contenu::class, 'content_id', 'id_contenu');
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }

    /**
     * Marquer le paiement comme complété
     */
    public function markAsCompleted()
    {
        $this->update([
            'status' => 'completed',
            'paid_at' => now(),
        ]);
    }

    /**
     * Marquer le paiement comme échoué
     */
    public function markAsFailed()
    {
        $this->update([
            'status' => 'failed',
        ]);
    }

    /**
     * Vérifier si le paiement est payé
     */
    public function isPaid()
    {
        return $this->status === 'completed';
    }

    /**
     * Vérifier si le paiement est en attente
     */
    public function isPending()
    {
        return in_array($this->status, ['pending', 'processing']);
    }

    /**
     * Scopes
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePending($query)
    {
        return $query->whereIn('status', ['pending', 'processing']);
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }
}