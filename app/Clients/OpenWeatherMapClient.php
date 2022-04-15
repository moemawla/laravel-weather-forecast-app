<?php

namespace App\Clients;

use GuzzleHttp\Client;

class OpenWeatherMapClient
{
    private const WEATHER_FORECAST_URL = 'https://api.openweathermap.org/data/2.5/onecall?lat=%s&lon=%s&appid=%s';

    /**
     * @var string
     */
    private $appId;

    /**
     * @var Client
     */
    private $httpClient;

    public function __construct(Client $client)
    {
        $this->appId = env('OPEN_WEATHER_APP_ID');
        $this->httpClient = $client;
    }

    public function getWeatherForcast(string $lat, string $lon): array
    {
        $request = $this->httpClient->get(sprintf(self::WEATHER_FORECAST_URL, $lat, $lon, $this->appId));

        return json_decode($request->getBody()->getContents(), true);
    }
}
