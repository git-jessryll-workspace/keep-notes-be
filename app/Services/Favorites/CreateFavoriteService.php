<?php

namespace App\Services\Favorites;

use App\Repositories\FavoriteRepository;

class CreateFavoriteService
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
     * @param array $payload
     * @return array
     */
    public function create(array $payload): array
    {
        $data = [
            'user_id' => auth()->id(),
            'favorable_id' => $payload['favorable_id'],
            'favorable_type' => $payload['favorable_type']
        ];

        $data['id'] = $this->favoriteRepository->create($data);
        return $data;
    }
}
