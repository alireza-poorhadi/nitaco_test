<?php

namespace App\Location;

use GuzzleHttp\Client;
use App\Location\Contract\LocationInterface;

class Mapbox implements LocationInterface
{
    public function getLocation(string $place) : array
    {
        # It's highly a good idea to have tokens in .env file. However, for your convenience, I've written the token as the default value here.
        $token = env('MAPBOX_ACCESS_TOKEN', 'pk.eyJ1IjoiYWxpcmV6YXBvb3JoYWRpIiwiYSI6ImNsMmdibzVuYzAxbnAzaW56d2Y4NnA3eWIifQ.2BEVDO1Uljxhjsbb4Miq6A');
        $apiBaseEndpoint = 'https://api.mapbox.com/geocoding/v5/mapbox.places/';
        $method = 'GET';
        $client = new Client();
        $response = $client->request($method, $apiBaseEndpoint . $place . '.json?access_token=' . $token);

        $response = json_decode($response->getBody());

        return [
            'longitude' => $response->features[0]->center[0],
            'latitude' => $response->features[0]->center[1]
        ];
    }
}
