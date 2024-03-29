<?php

namespace App\Repositories;

use App\Repositories\Pipelines\PipelineQuery;
use App\Repositories\Pipelines\QueryFilters\UserId;

class NoteRepository extends BaseDatabaseQuery
{
    /**
     * @var string
     */
    protected string $table = 'notes';

    /**
     * @return mixed
     */
    public function findAll(): mixed
    {
        $query = $this->model()->select(['id','title','body','updated_at']);
        return (new PipelineQuery($query, [
            UserId::class
        ]))->pipes()->get();
    }
}
