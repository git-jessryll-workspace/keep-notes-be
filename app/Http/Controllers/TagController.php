<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index(Request $request)
    {
        $tagQuery = Tag::query();

        if ($request->has('tag_type') && $request->has('tag_id')) {
            $tags = $tagQuery
                ->where('taggable_id', $request['tag_id'])
                ->where('taggable_type', $request['tag_type'])
                ->get();
            return response()->json($tags, 200);
        }
        $tags = Tag::query()->distinct()->get();

        return response()->json($tags, 200);
    }

    public function store(Request $request)
    {
        if ($request->has('tags')) {
            foreach ($request['tags'] as $key => $value) {
                dd($key, $value);
            }
        }


        $request->validate([
            'label' => 'required|min:3',
            'type' => 'required',
            'tag_id' => 'required'
        ]);

        $tagQuery = Tag::query();

        if (!in_array($request['type'], ['FOLDER', 'NOTE'])) {
            return response()->json(['error_message' => 'Something went wrong'], 401);
        }
        $tag = $tagQuery->where('label', $request['label'])
            ->where('taggable_id', $request['tag_id'])
            ->where('taggable_type', $request['type'])
            ->first();
        if ($tag) {
            return response()->json($tag, 201);
        }
        $data = [
            'label' => $request['label'],
            'taggable_id' => $request['tag_id'],
            'taggable_type' => $request['type']
        ];

        $tag = $tagQuery->create($data);
        return response()->json($tag, 201);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'label' => 'required|min:3',
            'type' => 'required',
            'tag_id' => 'required'
        ]);

        $tagQuery = Tag::query();

        if (!$tagQuery->where('id', $id)->first()) {
            return response()->json([
                'error_message' => 'Something went wrong!',
            ], 401);
        }

        if (!in_array($request['type'], ['FOLDER' . 'NOTE'])) {
            return response()->json(['error_message' => 'Something went wrong'], 401);
        }

        $data = [
            'label' => $request['label'],
            'taggable_id' => $request['tag_id']
        ];

        if ($request['type'] === 'folder') {
            $data['taggable_type'] = 'FOLDER';
        } else {
            $data['taggable_type'] = 'NOTE';
        }

        $tagQuery->where('id', $id)->update($data);
        return response()->json($tagQuery->where('id', $id)->first(), 201);
    }

    public function destroy($id)
    {
        Tag::query()->where('id', $id)->update([
            'taggable_id' => null,
            'taggable_type' => null,
        ]);
        return response()->json(['message' => 'Data deleted'], 204);
    }
}