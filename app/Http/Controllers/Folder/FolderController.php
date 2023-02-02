<?php

namespace App\Http\Controllers\Folder;

use App\Http\Controllers\Controller;
use App\Models\Folder;
use App\Models\Tag;
use Illuminate\Http\Request;

class FolderController extends Controller
{
    public function index()
    {
        $user = request()->user();
        $folderQuery = Folder::query();

        $folders = $folderQuery->where('user_id', $user->id)->get();

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
