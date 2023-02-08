<?php

namespace App\Repositories;

use App\Repositories\Pipelines\PipelineQuery;
use App\Repositories\Pipelines\QueryFilters\UserId;

class FolderRepository extends BaseDatabaseQuery
{
    public string $table = 'folders';

    /**
     * @return mixed
     */
    public function findAll(): mixed
    {
        $query = $this->model()->select(['folders.name', 'folders.id']);
        return (new PipelineQuery($query, [
            UserId::class
        ]))->pipes()->get();
    }
}
