<?php

namespace App\Http\Controllers\Folder;

use App\Http\Controllers\Controller;
use App\Models\Folder;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class FolderController extends Controller
{
    public function index()
    {
        // $folderIds = [];
        $userID= auth()->id();
        $folders = Cache::remember("{$userID}.folders", 60, function () {
            return DB::table('keep_notes_app.folders')
                ->where('user_id', auth()->id())
                ->select(['folders.name', 'folders.id'])
                ->get();
        });
        // foreach ($folders as $folder) {
        //     $folderIds[] = $folder->id;
        // }
        // $folderNotes = DB::table('keep_notes_app.folder_notes')
        //     ->select([
        //         'folder_notes.id',
        //         'folder_notes.folder_id',
        //         'folder_notes.note_id'
        //     ])
        //     ->whereIn('folder_notes.folder_id', $folderIds)
        //     ->get();
        // foreach ($folders as $folder) {
        //     $list = [];
        //     foreach ($folderNotes as $folderNote) {
        //         if ($folder->id === $folderNote->folder_id) {
        //             $list[] = $folderNote;
        //         }
        //     }
        //     $folder['folder_notes'] = $list;
        // }

        return response()->json($folders, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:4'
        ]);
        $folder = Folder::query()->create([
            'name' => $request['name'],
            'user_id' => $request->user()->id,
        ]);
        return response()->json($folder, 201);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'name' => 'required|min:4'
        ]);

        Folder::query()->where('id', $id)->update([
            'name' => $request['name']
        ]);
        $folder = Folder::query()->where('id', $id)->first();
        return response()->json($folder, 201);
    }

    public function destroy($id, Request $request)
    {
        Folder::query()->where('id', $id)->where('user_id', $request->user()->id)->delete();
        Tag::query()->where('taggable_id', $id)->where('taggable_type', 'FOLDER')->update([
            'taggable_id' => null,
            'taggable_type' => null
        ]);

        return response()->json(['message' => 'Data deleted'], 204);
    }
}
