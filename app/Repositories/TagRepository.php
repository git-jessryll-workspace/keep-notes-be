<?php

namespace App\Repositories;

use App\Repositories\Pipelines\QueryFilters\TaggableType;
use App\Repositories\Pipelines\QueryWhereIn\TaggableIds;
use Illuminate\Pipeline\Pipeline;

class TagRepository extends BaseDatabaseQuery
{
    public string $table = 'tags';

    public function findAll()
    {
        return app(Pipeline::class)
            ->send($this->model()->select(['id','label', 'taggable_id']))
            ->through([
                TaggableType::class,
                TaggableIds::class
            ])
            ->thenReturn()
            ->get();
    }
}
