<?php

namespace App;

use GuzzleHttp\Client;

class GetPassengerSource
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @throws \JsonException|\GuzzleHttp\Exception\GuzzleException
     */
    public function getPlaceName($latitude, $longitude)
    {
        $response = $this->client->get('https://maps.googleapis.com/maps/api/geocode/json', [
            'query' => [
                'latlng' => "{$latitude},{$longitude}",
                'key' => env('GOOGLE_MAPS_API_KEY'),
            ],
        ]);

        $data = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);

        return $data['results'][0]['formatted_address'] ?? 'Unknown';
    }
}