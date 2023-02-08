<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFavoriteRequest;
use App\Services\Favorites\CreateFavoriteService;
use App\Services\Favorites\DeleteFavoriteService;
use App\Services\Favorites\FetchAllFavoriteService;
use Illuminate\Http\JsonResponse;

class FavoriteController extends Controller
{
    /**
     * @param FetchAllFavoriteService $fetchAllFavoriteService
     * @return JsonResponse
     */
    public function index(FetchAllFavoriteService $fetchAllFavoriteService): JsonResponse
    {
        return response()->json($fetchAllFavoriteService->all());
    }

    /**
     * @param StoreFavoriteRequest $request
     * @param CreateFavoriteService $createFavoriteService
     * @return JsonResponse
     */
    public function store(StoreFavoriteRequest $request, CreateFavoriteService $createFavoriteService): JsonResponse
    {
        return response()->json($createFavoriteService->create([
            'favorable_id' => $request['favorable_id'],
            'favorable_type' => $request['favorable_type']
        ]), 201);
    }

    /**
     * @param $id
     * @param DeleteFavoriteService $deleteFavoriteService
     * @return JsonResponse
     */
    public function destroy($id, DeleteFavoriteService $deleteFavoriteService): JsonResponse
    {
        return response()->json($deleteFavoriteService->delete((int) $id),204);
    }
}
