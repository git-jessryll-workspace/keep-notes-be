<?php

namespace App\Repositories\Pipelines\QueryFilters;

use App\Repositories\Pipelines\Filter;

class FavorableId extends Filter
{

    protected function applyFilter($builder)
    {
        return $builder->where('favorable_id', request()[$this->filterName()]);
    }
}
