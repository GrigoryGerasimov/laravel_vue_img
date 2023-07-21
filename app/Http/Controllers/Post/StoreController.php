<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StoreRequest;
use Carbon\Carbon;
use App\Models\{Image, Post};
use Illuminate\Support\Facades\Storage;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();

        $images = $data['images'];
        unset($data['images']);

        $post = Post::firstOrCreate(['title' => $data['title']], $data);

        foreach ($images as $image) {
            $imgPathName = Carbon::now()->timestamp . $image->getClientOriginalName();
            Storage::disk('public')->putFileAs('images/', $image, $imgPathName);

            Image::create([
                'path' => $imgPathName,
                'url' => url('/storage/images/' . $imgPathName),
                'post_id' => $post->id
            ]);
        }
    }
}
