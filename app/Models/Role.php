<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';
    protected $primaryKey = 'id_role';
    
    protected $fillable = [
        'nom_role'
    ];

    public $timestamps = true;

    // Relation avec les utilisateurs
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_role', 'id_role', 'user_id');
    }

  
}