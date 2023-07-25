<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StoreRequest;
use Carbon\Carbon;
use App\Models\{Image, Post};
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as InterventionImage;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request): void
    {
        $data = $request->validated();

        $images = $data['images'];
        unset($data['images']);

        $post = Post::firstOrCreate(['title' => $data['title']], $data);

        foreach ($images as $image) {
            $imgPathName = md5(Carbon::now()->timestamp . $image->getClientOriginalName()) . '.' . $image->getClientOriginalExtension();
            $imgPath = Storage::disk('public')->putFileAs('images', $image, $imgPathName);
            $prevImgPath = 'prev_' . $imgPathName;

            $urlPath = url('/storage/' . $imgPath);
            $prevUrlPath = url('/storage/images/prev/' . $prevImgPath);

            if (!file_exists('storage/images/prev')) {
                mkdir('storage/images/prev', 0775, true);
            }
            InterventionImage::make($image)->fit(100, 100)->save('storage/images/prev/' . $prevImgPath);

            Image::create([
                'path' => $imgPathName,
                'url' => $urlPath,
                'preview_url' => $prevUrlPath,
                'post_id' => $post->id
            ]);
        }
    }
}
