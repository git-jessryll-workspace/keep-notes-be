<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends BaseDatabaseModel
{
    use HasFactory;

    protected $table = 'tags';

    protected $fillable = ['label', 'taggable_id', 'taggable_type'];
}
