<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Utilisateur extends Model
{
    use HasFactory;

    protected $table = 'utilisateurs';
    protected $primaryKey = 'id_utilisateur';
    
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'mot_de_passe',
        'sexe',
        'date_inscription',
        'date_naissance',
        'statut',
        'photo',
        'id_role',
        'id_langue'
    ];

    protected $hidden = [
        'mot_de_passe'
    ];

    public $timestamps = true;

    // Relation avec le rôle
    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role');
    }

    // Relation avec la langue
    public function langue()
    {
        return $this->belongsTo(Langue::class, 'id_langue');
    }

    // Relation avec les contenus (en tant qu'auteur)
    public function contenus()
    {
        return $this->hasMany(Contenu::class, 'id_auteur');
    }

    // Relation avec les commentaires
    public function commentaires()
    {
        return $this->hasMany(Commentaire::class, 'id_utilisateur');
    }
}