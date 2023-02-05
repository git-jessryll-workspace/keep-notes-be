<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends BaseDatabaseModel
{
    use HasFactory;

    protected $table = 'folders';

    protected $fillable = ['name', 'user_id'];
}
