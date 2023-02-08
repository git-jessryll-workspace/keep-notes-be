<?php

namespace App\Repositories\Pipelines\QueryFilters;

use App\Repositories\Pipelines\Filter;

class TaggableId extends Filter
{
    /**
     * @param $builder
     * @return mixed
     */
    protected function applyFilter($builder): mixed
    {
        return $builder->where('taggable_id', request()[$this->filterName()]);
    }
}
