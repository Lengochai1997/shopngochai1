<?php

namespace App\Services;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client as GuzzleClient;

class ImgurService
{
    const END_POINT = 'https://api.imgur.com/3/image';

    public static function uploadImage($imagePath)
    {
        $client = new GuzzleClient();
        $config = getConfig(config('setting.IMGUR'));
        $client_id = isset($config['client_id']) ? $config['client_id'] : env('CLIENT_ID');
        $request = $client->request(
            'POST',
            ImgurService::END_POINT,
            [
                'headers' => [
                    'Authorization' => "Client-ID ".$client_id, // post as anonymous
                ],
                'form_params' => [
                    'image' => file_get_contents($imagePath)
                ]
            ]
        );
        $response = (string) $request->getBody();
        $jsonResponse = json_decode($response);
        return $jsonResponse->data->link;
    }
}
