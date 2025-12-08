<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $table = 'medias';
    protected $primaryKey = 'id_media';
    
    protected $fillable = [
        'chemin',
        'description',
        'id_contenu',
        'id_type_media'
    ];

    public $timestamps = true;

    // Relation avec le contenu
    public function contenu()
    {
        return $this->belongsTo(Contenu::class, 'id_contenu');
    }

    // Relation avec le type de média
    public function typeMedia()
    {
        return $this->belongsTo(TypeMedia::class, 'id_type_media');
    }
}