<?php

namespace App\Http\Controllers\Folder;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFolderNoteRequest;
use App\Services\FolderNotes\CreateFolderNoteService;
use App\Services\FolderNotes\DeleteFolderNoteService;
use App\Services\FolderNotes\FetchAllFolderNoteService;
use Illuminate\Http\JsonResponse;

class FolderNoteController extends Controller
{
    /**
     * @param FetchAllFolderNoteService $fetchAllFolderNoteService
     * @return JsonResponse
     */
    public function index(FetchAllFolderNoteService $fetchAllFolderNoteService): JsonResponse
    {
        return response()->json($fetchAllFolderNoteService->all());
    }

    /**
     * @param StoreFolderNoteRequest $request
     * @param CreateFolderNoteService $createFolderNoteService
     * @return JsonResponse
     */
    public function store(StoreFolderNoteRequest $request, CreateFolderNoteService $createFolderNoteService): JsonResponse
    {
        return response()->json($createFolderNoteService->create([
            'folder_id' => $request['folder_id'],
            'note_id' => $request['note_id']
        ]), 201);
    }

    /**
     * @param $id
     * @param DeleteFolderNoteService $deleteFolderNoteService
     * @return JsonResponse
     */
    public function destroy($id, DeleteFolderNoteService $deleteFolderNoteService): JsonResponse
    {
        return response()->json($deleteFolderNoteService->delete((int) $id), 204);
    }
}
