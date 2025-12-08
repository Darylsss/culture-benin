<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model
{
    use HasFactory;

    protected $table = 'commentaires';
    protected $primaryKey = 'id_commentaire';
    
    protected $fillable = [
        'texte',
        'note',
        'date',
        'id_utilisateur',
        'id_contenu'
    ];

    public $timestamps = true;

    // Relation avec l'utilisateur
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'id_utilisateur');
    }

    // Relation avec le contenu
    public function contenu()
    {
        return $this->belongsTo(Contenu::class, 'id_contenu');
    }
}