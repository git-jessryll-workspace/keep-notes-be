<?php

namespace App\Services\Favorites;

use App\Repositories\FavoriteRepository;
use App\Repositories\Pipelines\PipelineQuery;
use App\Repositories\Pipelines\QueryFilters\UserId;

class FetchAllFavoriteService
{
    /**
     * @var FavoriteRepository
     */
    private FavoriteRepository $favoriteRepository;

    /**
     * @param FavoriteRepository $favoriteRepository
     */
    public function __construct(FavoriteRepository $favoriteRepository)
    {
        $this->favoriteRepository = $favoriteRepository;
    }

    /**
     * @return mixed
     */
    public function all(): mixed
    {
        return (new PipelineQuery(
            $this->favoriteRepository->model()->select(['id', 'user_id', 'favorable_id', 'favorable_type']),
            [
                UserId::class
            ]
        ))->pipes()->get();
    }
}
