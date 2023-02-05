<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends BaseDatabaseModel
{
    use HasFactory;

    protected $table = 'notes';

    protected $fillable = ['title', 'body','user_id', 'is_active'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }    
}
