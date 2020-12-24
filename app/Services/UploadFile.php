<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadFile {

    public static function upload($file, $location = 'images')
    {
        $filename = time().'_'.$file->getClientOriginalName();
        $upload = Storage::disk($location)->put($filename, file_get_contents($file->getRealPath()));
        if ($upload) {
            return $location.'/'.$filename;
        }
        return '';
    }

    public static function uploadFromPublic($file, $location)
    {
        $nameReal = $file->getClientOriginalName();
        $name = Str::random(10). '_' . $nameReal;
        while (file_exists('upload/'.$location.'/'.$name)) {
            $name = Str::random(10). '_' . $nameReal;
        }
        $file->move('upload/'.$location, $name);
        return 'upload/'.$location.'/'.$name;
    }
}
