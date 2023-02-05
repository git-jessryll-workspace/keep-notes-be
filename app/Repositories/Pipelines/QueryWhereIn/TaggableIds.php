<?php

namespace App\Repositories\Pipelines\QueryWhereIn;

use App\Repositories\Pipelines\Filter;

class TaggableIds extends Filter
{

    protected function applyFilter($builder)
    {
        return $builder->whereIn('taggable_id', request()[$this->filterName()]);
    }
}
