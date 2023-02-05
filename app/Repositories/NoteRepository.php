<?php

namespace App\Repositories;

use App\Repositories\Pipelines\QueryFilters\UserId;
use Illuminate\Pipeline\Pipeline;

class NoteRepository extends BaseDatabaseQuery
{
    protected string $table = 'notes';

    public function findAll()
    {
        return app(Pipeline::class)
            ->send($this->model()->select(['id','title','body','updated_at']))
            ->through([
                UserId::class
            ])
            ->thenReturn()
            ->get();
    }
}
