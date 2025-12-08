<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contenu extends Model
{
    use HasFactory;

    protected $table = 'contenus';
    protected $primaryKey = 'id_contenu';
    
    protected $fillable = [
        'titre',
        'texte',
        'date_creation',
        'statut',
        'parent_id',
        'date_validation',
        'id_region',
        'id_langue',
        'id_moderateur',
        'id_type_contenu',
        'id_auteur'
    ];

    public $timestamps = true;

    // Relation avec la région
    public function region()
    {
        return $this->belongsTo(Region::class, 'id_region');
    }

    // Relation avec la langue
    public function langue()
    {
        return $this->belongsTo(Langue::class, 'id_langue');
    }

    // Relation avec le type de contenu
    public function typeContenu()
    {
        return $this->belongsTo(TypeContenu::class, 'id_type_contenu');
    }

    // Relation avec l'auteur (utilisateur)
    public function auteur()
    {
        return $this->belongsTo(Utilisateur::class, 'id_auteur');
    }

    // Relation avec le modérateur (utilisateur)
    public function moderateur()
    {
        return $this->belongsTo(Utilisateur::class, 'id_moderateur');
    }

    // Relation parent-enfant (contenus liés)
    public function parent()
    {
        return $this->belongsTo(Contenu::class, 'parent_id');
    }

    public function enfants()
    {
        return $this->hasMany(Contenu::class, 'parent_id');
    }

    // Relation avec les médias
    public function medias()
    {
        return $this->hasMany(Media::class, 'id_contenu');
    }

    // Relation avec les commentaires
    public function commentaires()
    {
        return $this->hasMany(Commentaire::class, 'id_contenu');
    }

    public function payments()
{
    return $this->hasMany(Payment::class, 'content_id', 'id_contenu');
}
}