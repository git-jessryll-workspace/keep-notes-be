<?php

namespace App\Repositories\Pipelines;

use Illuminate\Database\Query\Builder;
use Illuminate\Pipeline\Pipeline;

class PipelineQuery
{
    private Builder $query;
    private array $queryClasses;


    public function __construct(Builder $query, array $queryClasses = [])
    {
        $this->query = $query;
        $this->queryClasses = $queryClasses;
    }

    /**
     * @return mixed
     */
    public function pipes(): mixed
    {
        return app(Pipeline::class)
            ->send($this->query)
            ->through($this->queryClasses)
            ->thenReturn();
    }
}
