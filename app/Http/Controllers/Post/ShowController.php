<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;

class ShowController extends Controller
{
    public function __invoke(Post $post): PostResource
    {
        return new PostResource($post);
    }
}
