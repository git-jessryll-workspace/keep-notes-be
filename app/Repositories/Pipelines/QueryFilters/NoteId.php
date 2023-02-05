<?php

namespace App\Repositories\Pipelines\QueryFilters;

use App\Repositories\Pipelines\Filter;

class NoteId extends Filter
{

    /**
     * @param $builder
     * @return mixed
     */
    protected function applyFilter($builder): mixed
    {
        return $builder->where('note_id', request()[$this->filterName()]);
    }
}
