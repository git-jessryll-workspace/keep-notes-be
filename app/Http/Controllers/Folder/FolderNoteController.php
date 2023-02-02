<?php

namespace App\Http\Controllers\Folder;

use App\Http\Controllers\Controller;
use App\Models\FolderNote;
use Illuminate\Http\Request;

class FolderNoteController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'folder_id' => 'required',
            'note_id' => 'required'
        ]);
        $data = [
            'folder_id' => $request['folder_id'],
            'note_id' => $request['note_id'],
            'user_id' => $request->user()->id,
        ];
        $folderNote = FolderNote::query()->create($data);

        return response()->json($folderNote, 201);
    }

    public function destroy($id)
    {

        FolderNote::query()->where('id', $id)->delete();
        return response()->json([
            'message' => 'Data deleted'
        ], 204);
    }
}
