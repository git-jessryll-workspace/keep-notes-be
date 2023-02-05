<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNote extends BaseDatabaseModel
{
    use HasFactory;

    protected $table = 'user_notes';
}
