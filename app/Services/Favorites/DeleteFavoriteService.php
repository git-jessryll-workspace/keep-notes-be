<?php

namespace App\Services\Favorites;

use App\Repositories\FavoriteRepository;

class DeleteFavoriteService
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
     * @param int $id
     * @return string[]
     */
    public function delete(int $id): array
    {
        $this->favoriteRepository->delete($id);
        return ['message' => 'data deleted'];
    }
}
