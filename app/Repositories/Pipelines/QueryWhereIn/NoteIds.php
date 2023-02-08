<?php

namespace App\Repositories\Pipelines\QueryWhereIn;

use App\Repositories\Pipelines\Filter;

class NoteIds extends Filter
{

    protected function applyFilter($builder)
    {
        return $builder->whereIn('note_id', request()[$this->filterName()]);
    }
}
