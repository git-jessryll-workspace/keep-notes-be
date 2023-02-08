<?php

namespace App\Repositories\Pipelines\QueryWhereIn;

use App\Repositories\Pipelines\Filter;

class FolderIds extends Filter
{

    protected function applyFilter($builder)
    {
        return $builder->whereIn('folder_id', request()[$this->filterName()]);
    }
}
