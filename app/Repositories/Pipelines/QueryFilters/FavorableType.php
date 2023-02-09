<?php

namespace App\Repositories\Pipelines\QueryFilters;

use App\Repositories\Pipelines\Filter;

class FavorableType extends Filter
{

    protected function applyFilter($builder)
    {
        return $builder->where('favorable_type', request()[$this->filterName()]);
    }
}
