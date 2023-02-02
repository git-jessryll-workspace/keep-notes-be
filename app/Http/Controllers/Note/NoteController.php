<?php

namespace App\Http\Controllers\Note;

use App\Http\Controllers\Controller;
use App\Models\FolderNote;
use App\Models\Note;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NoteController extends Controller
{
    /**
     * Data created
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:3',
        ]);

        $userId = $request->user()->id;

        $note = Note::create([
            'title' => $request['title'],
            'body' => $request['body'],
            'user_id' => $userId,
        ]);
        return response()->json($note, 201);
    }
    /**
     * Data updated
     *
     * @param [type] $id
     * @param Request $request
     * @return void
     */
    public function update($id, Request $request)
    {
        $request->validate([
            'title' => 'required|min:3',
        ]);

        $note = Note::find($id);

        if (!$note) {
            return response()->json([
                'error_message' => 'Data not found',
            ], 404);
        }

        Note::where('id', $id)->update([
            'title' => $request['title'],
            'body' => $request['body']
        ]);

        $note = Note::find($id);


        return response()->json([
            'id' => $id,
            'title' => $request['title'],
            'body' => $request['body'],
            'updated_at' => $note->updated_at,
        ], 201);
    }
    /**
     * Data Deleted
     *
     * @param [type] $id
     * @param Request $request
     * @return void
     */
    public function destroy($id, Request $request)
    {
        $note = Note::find($id);

        if (!$note) {
            return response()->json([
                'error_message' => "Data not found",
            ], 404);
        }

        if ($note->user_id !== $request->user()->id) {
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
     * Get Data details
     *
     * @param [type] $id
     * @return void
     */
    public function show($id)
    {
        $note = Note::find($id);

        if (!$note) {
            return response()->json([
                'error_message' => "Data not found",
            ], 404);
        }

        return response()->json($note->toArray(), 200);
    }
    /**
     * get all note list
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $notes = Note::where('user_id', $request->user()->id)->get();
        $noteIds = $notes->map(function ($item) {
            return $item->id;
        });
        $tags = Tag::query()
            ->whereIn('taggable_id', $noteIds)
            ->where('taggable_type', 'NOTE')
            ->get();
        $folderNotes = FolderNote::query()
            ->whereIn('note_id', $noteIds)
            ->where('user_id', $request->user()->id)
            ->get();

        foreach ($notes as $note) {
            $noteTags = $tags->where('taggable_id', $note->id);
            $tagList = [];
            foreach ($noteTags as $tag) {
                array_push($tagList, $tag);
            }
            $folderNote = $folderNotes->where('note_id', $note->id)->first();
            $note['tags'] = $tagList;
            $note['folder'] = $folderNote;
        }


        return response()->json($notes, 200);
    }
}
