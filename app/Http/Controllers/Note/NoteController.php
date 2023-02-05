<?php

namespace App\Http\Controllers\Note;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Models\FolderNote;
use App\Models\Note;
use App\Models\Tag;
use App\Services\Notes\FetchAllNoteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NoteController extends Controller
{
    /**
     * @param StoreNoteRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreNoteRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = [
            'title' => $request['title'],
            'body' => $request['body'],
            'user_id' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        $data['id'] = DB::table('keep_notes_app.notes')->insertGetId($data);
        return response()->json($data, 201);
    }

    /**
     * @param $id
     * @param UpdateNoteRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdateNoteRequest $request): \Illuminate\Http\JsonResponse
    {

        DB::table('keep_notes_app.notes')
            ->where('id', $id)
            ->update([
                'title' => $request['title'],
                'body' => $request['body'],
                'updated_at' => now()
            ]);

        return response()->json([
            'id' => $id,
            'title' => $request['title'],
            'body' => $request['body'],
            'updated_at' => now(),
        ], 200);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        $note = DB::table('keep_notes_app.notes')
            ->where('id', $id)
            ->select(['id'])
            ->first();

        if (!$note) {
            return response()->json([
                'error_message' => "Data not found",
            ], 404);
        }

        if ($note->user_id !== auth()->id()) {
            return response()->json([
                'error_message' => "Not Authorized",
            ], 401);
        }

        $note->delete();

        return response()->json([
            'message' => 'Data deleted'
        ], 204);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id): \Illuminate\Http\JsonResponse
    {
        $note = DB::table('keep_notes_app.notes')
            ->where('id', $id)
            ->select(['title', 'body', 'id', 'updated_at', 'is_active'])
            ->first();

        if (!$note) {
            return response()->json([
                'error_message' => "Data not found",
            ], 404);
        }

        return response()->json($note, 200);
    }

    public function index(Request $request, FetchAllNoteService $fetchAllNoteService): \Illuminate\Http\JsonResponse
    {
        $notes = $fetchAllNoteService->all();
        


        return response()->json($notes, 200);
    }
}
