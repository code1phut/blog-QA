<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TagController extends Controller
{
    public function getTags()
    {
        return Tag::query()->orderBy('id', 'desc')->get();
    }

    public function addTags(Request $request): \Illuminate\Http\JsonResponse
    {
        $tag = Tag::create([
           'name' => $request->get('name'),
        ]);

        return response()->json([
            'data' => $tag
        ], Response::HTTP_OK);
    }
}
