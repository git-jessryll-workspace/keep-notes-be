<?php

namespace App\Http\Controllers\Folder;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFolderRequest;
use App\Http\Requests\UpdateFolderRequest;
use App\Services\Folders\CreateFolderService;
use App\Services\Folders\DeleteFolderService;
use App\Services\Folders\FetchAllFolderService;
use App\Services\Folders\UpdateFolderService;
use Illuminate\Http\JsonResponse;

class FolderController extends Controller
{
    /**
     * @param FetchAllFolderService $fetchAllFolderService
     * @return JsonResponse
     */
    public function index(FetchAllFolderService $fetchAllFolderService): JsonResponse
    {
        return response()->json($fetchAllFolderService->all(), 200);
    }

    /**
     * @param StoreFolderRequest $request
     * @param CreateFolderService $createFolderService
     * @return JsonResponse
     */
    public function store(StoreFolderRequest $request, CreateFolderService $createFolderService): JsonResponse
    {
        return response()->json(
            $createFolderService->create([
                'name' => $request['name'],
            ]), 201);
    }

    /**
     * @param $id
     * @param UpdateFolderRequest $request
     * @param UpdateFolderService $updateFolderService
     * @return JsonResponse
     */
    public function update($id, UpdateFolderRequest $request, UpdateFolderService $updateFolderService): JsonResponse
    {
        return response()->json($updateFolderService->update((int)$id, [
            'name' => $request['name']
        ]), 201);
    }

    /**
     * @param $id
     * @param DeleteFolderService $deleteFolderService
     * @return JsonResponse
     */
    public function destroy($id, DeleteFolderService $deleteFolderService): JsonResponse
    {
        return response()->json($deleteFolderService->delete((int)$id), 204);
    }
}
