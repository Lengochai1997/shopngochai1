<?php

namespace App\Http\Controllers\Upload;

use App\Http\Controllers\Controller;
use App\Services\ImgbbService;
use App\Services\ImgurService;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function uploadImage(Request $request)
    {
        $image = $request->file('file');
        $url = ImgbbService::uploadImage($image);
        return response()->json([
            'status' => 'success',
            'url' => $url
        ], 200);
    }
}
