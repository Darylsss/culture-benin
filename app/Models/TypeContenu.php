<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeContenu extends Model
{
    use HasFactory;

    protected $table = 'type_contenus';
    protected $primaryKey = 'id_type_contenu';
    
    protected $fillable = [
        'nom_contenu'
    ];

    public $timestamps = true;

  
}