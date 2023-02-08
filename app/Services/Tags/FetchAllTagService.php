<?php

namespace App\Services\Tags;

use App\Repositories\Pipelines\Distinct;
use App\Repositories\Pipelines\PipelineQuery;
use App\Repositories\Pipelines\QueryFilters\TaggableType;
use App\Repositories\Pipelines\QueryWhereIn\TaggableIds;
use App\Repositories\TagRepository;

class FetchAllTagService
{
    /**
     * @var TagRepository
     */
    private TagRepository $tagRepository;

    /**
     * @param TagRepository $tagRepository
     */
    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    /**
     * @return mixed
     */
    public function all(): mixed
    {
        $this->filterSetter();
        $query = $this->tagRepository->model()->select(['id', 'label', 'taggable_id']);
        $queryClasses = [
            TaggableType::class,
            TaggableIds::class,
            Distinct::class
        ];
        return (new PipelineQuery($query, $queryClasses))->pipes()->get();
    }

    /**
     * @return void
     */
    private function filterSetter(): void
    {
        if (request()->has('tag_type') && request()->has('tag_id')) {
            request()['taggable_id'] = request()['tag_id'];
            request()['taggable_type'] = request()['tag_type'];
            return;
        }
        request()['need_distinct'] = 1;
    }
}
