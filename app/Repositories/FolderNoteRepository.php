<?php

namespace App\Repositories;

use App\Repositories\Pipelines\QueryFilters\NoteId;
use App\Repositories\Pipelines\QueryFilters\UserId;
use Illuminate\Pipeline\Pipeline;

class FolderNoteRepository extends BaseDatabaseQuery
{
    public string $table = 'folder_notes';

    public function findAll()
    {
        return app(Pipeline::class)
            ->send($this->model()->select(['id', 'folder_id', 'note_id']))
            ->through([
                NoteId::class,
                UserId::class
            ])
            ->thenReturn()
            ->get();
    }
}
