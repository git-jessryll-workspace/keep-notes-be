<?php

namespace App\Http\Controllers\Note;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Services\Notes\CreateNoteService;
use App\Services\Notes\DeleteNoteService;
use App\Services\Notes\FetchAllNoteService;
use App\Services\Notes\ShowNoteService;
use App\Services\Notes\UpdateNoteService;
use Illuminate\Http\JsonResponse;

class NoteController extends Controller
{
    /**
     * @param StoreNoteRequest $request
     * @param CreateNoteService $createNoteService
     * @return JsonResponse
     */
    public function store(StoreNoteRequest $request, CreateNoteService $createNoteService): JsonResponse
    {
        $data = ['title' => $request['title'], 'body' => $request['body']];
        return response()->json($createNoteService->create($data), 201);
    }


    /**
     * @param $id
     * @param UpdateNoteRequest $request
     * @param UpdateNoteService $updateNoteService
     * @return JsonResponse
     */
    public function partialUpdate($id, UpdateNoteRequest $request, UpdateNoteService $updateNoteService): JsonResponse
    {
        return response()->json($updateNoteService->update((int)$id, [
            'title' => $request['title'],
            'body' => $request['body']
        ]), 200);
    }

    /**
     * @param $id
     * @param DeleteNoteService $deleteNoteService
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function destroy($id, DeleteNoteService $deleteNoteService): JsonResponse
    {
        return response()->json($deleteNoteService->delete((int) $id), 204);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id, ShowNoteService $showNoteService): JsonResponse
    {
        return response()->json($showNoteService->show((int) $id), 200);
    }

    /**
     * @param FetchAllNoteService $fetchAllNoteService
     * @return JsonResponse
     */
    public function index(FetchAllNoteService $fetchAllNoteService): JsonResponse
    {
        return response()->json($fetchAllNoteService->all(), 200);
    }
}
