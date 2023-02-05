<?php

namespace App\Http\Controllers\Folder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FolderNoteController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $userId = auth()->id();
        $folderNotes = DB::table('keep_notes_app.folder_notes')
            ->where('folder_notes.user_id', $userId)
            ->select(['id', 'user_id', 'folder_id', 'note_id'])
            ->get();
        return response()->json($folderNotes);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'folder_id' => 'required',
            'note_id' => 'required'
        ]);
        $data = [
            'folder_id' => $request['folder_id'],
            'note_id' => $request['note_id'],
            'user_id' => $request->user()->id,
            'created_at' => now(),
            'updated_at' => now()
        ];
        $data['id'] = DB::table('keep_notes_app.folder_notes')->insertGetId($data);

        return response()->json($data, 201);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        DB::table('keep_notes_app.folder_notes')
            ->where('id', $id)
            ->delete();
        return response()->json([
            'message' => 'Data deleted'
        ], 204);
    }
}
