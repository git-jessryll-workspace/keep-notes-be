<?php

namespace App\Repositories;

use App\Repositories\Pipelines\PipelineQuery;
use App\Repositories\Pipelines\QueryFilters\Label;
use App\Repositories\Pipelines\QueryFilters\TaggableId;
use App\Repositories\Pipelines\QueryFilters\TaggableType;

class TagRepository extends BaseDatabaseQuery
{
    /**
     * @var string
     */
    public string $table = 'tags';

    private array $commonSelect = ['id', 'label', 'taggable_id'];

    /**
     * @return mixed
     */
    public function findFirst(): mixed
    {
        $query = $this->model()->select($this->commonSelect);
        $queryClasses = [
            TaggableId::class,
            TaggableType::class,
            Label::class
        ];
        return (new PipelineQuery($query, $queryClasses))->pipes()->first();
    }
}
