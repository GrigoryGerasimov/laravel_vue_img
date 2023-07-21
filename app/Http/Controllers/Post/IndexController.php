<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class IndexController extends Controller
{
    public function __invoke(): AnonymousResourceCollection
    {
        $postsList = Post::all();

        return PostResource::collection($postsList);
    }
}
