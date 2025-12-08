<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $table = 'regions';
    protected $primaryKey = 'id_region';
    
    protected $fillable = [
        'nom_region',
        'description',
        'population',
        'superficie',
        'localisation'
    ];

    public $timestamps = true;

    // Relation avec les langues (table parler)
    public function langues()
    {
        return $this->belongsToMany(Langue::class, 'parler', 'id_region', 'id_langue');
    }

  
}