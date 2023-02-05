<?php

namespace App\Repositories\Pipelines\QueryFilters;

use App\Repositories\Pipelines\Filter;

class UserId extends Filter
{

    /**
     * @param $builder
     * @return mixed
     */
    protected function applyFilter($builder): mixed
    {
        return $builder->where('user_id', request()[$this->filterName()]);
    }
}
