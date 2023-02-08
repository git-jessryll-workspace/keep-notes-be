<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTagRequest;
use App\Services\Tags\CreateTagService;
use App\Services\Tags\DeleteTagService;
use App\Services\Tags\FetchAllTagService;
use Illuminate\Http\JsonResponse;

class TagController extends Controller
{
    /**
     * @param FetchAllTagService $fetchAllTagService
     * @return JsonResponse
     */
    public function index(FetchAllTagService $fetchAllTagService): JsonResponse
    {
        return response()->json($fetchAllTagService->all());
    }

    /**
     * @param StoreTagRequest $request
     * @param CreateTagService $createTagService
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(StoreTagRequest $request, CreateTagService $createTagService): JsonResponse
    {
        $tag = $createTagService->create([
            'label' => $request['label'],
            'type' => $request['type'],
            'tag_id' => $request['tag_id']
        ]);
        return response()->json($tag, 201);
    }

    /**
     * @param $id
     * @param DeleteTagService $deleteTagService
     * @return JsonResponse
     */
    public function destroy($id, DeleteTagService $deleteTagService): JsonResponse
    {
        return response()->json($deleteTagService->delete((int) $id), 204);
    }
}
