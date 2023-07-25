<?php

namespace App\Http\Controllers\Post\Image;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\Image\StoreRequest;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $image = $data['image'];

        $imagePathName = md5(Carbon::now() . $image->getClientOriginalName()) . '.' . $image->getClientOriginalExtension();
        $imagePath = Storage::disk('public')->putFileAs('images/content', $image, $imagePathName);

        return response()->json(['url' => url('/storage', $imagePath)]);
    }
}
