<?php

namespace App\Services;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client as GuzzleClient;

class ImgbbService
{
    const END_POINT = 'https://api.imgbb.com/1/upload';

    public static function uploadImage($imagePath)
    {
        $client = new GuzzleClient();
        $request = $client->request(
            'POST',
            ImgbbService::END_POINT,
            [
                'form_params' => [
                    'key' => '436d34fee6d1ef2da7c298deba24d57f',
                    'image' => base64_encode(file_get_contents($imagePath)),
                ]
            ]
        );
        $response = (string) $request->getBody();
        $jsonResponse = json_decode($response);
        return $jsonResponse->data->url;
    }
}
