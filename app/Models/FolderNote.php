<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FolderNote extends BaseDatabaseModel
{
    use HasFactory;

    protected $table = 'folder_notes';

    protected $fillable = ['folder_id', 'user_id', 'note_id'];
}
