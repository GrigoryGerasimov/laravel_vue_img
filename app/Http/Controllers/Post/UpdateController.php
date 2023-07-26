<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\UpdateRequest;
use App\Models\{Image, Post};
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as InterventionImage;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request, Post $post)
    {
        $data = $request->validated();

        if (key_exists('images', $data)) {
            $images = $data['images'];
            unset($data['images']);
        }

        if (key_exists('image_ids_to_remove', $data)) {
            $imageIdsToRemove = $data['image_ids_to_remove'];
            unset($data['image_ids_to_remove']);
        }

        $post->update($data);

        if (isset($images)) {
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

        if (isset($imageIdsToRemove)) {
            foreach ($post->images as $postImage) {
                if (in_array($postImage->id, $imageIdsToRemove)) {
                    Storage::disk('public')->delete('images/' . $postImage->path);
                    Storage::disk('public')->delete('images/prev/' . 'prev_' . $postImage->path);
                    $postImage->delete();
                }
            }
        }
    }
}
