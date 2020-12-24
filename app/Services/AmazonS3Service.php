<?php


namespace App\Services;


use Illuminate\Support\Facades\Storage;

class AmazonS3Service
{
    public function __construct()
    {

    }

    public function getUrl($file)
    {
        return Storage::disk('s3')->url($file);
    }

    public function postUpload($file)
    {
        $path = Storage::disk('s3')->put('images/test', $file, 'public');
        return Storage::disk('s3')->url($path);
    }
}
