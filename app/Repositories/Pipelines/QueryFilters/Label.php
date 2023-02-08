<?php

namespace App\Repositories\Pipelines\QueryFilters;

use App\Repositories\Pipelines\Filter;

class Label extends Filter
{

    protected function applyFilter($builder)
    {
        return $builder->where('label', request()[$this->filterName()]);
    }
}
