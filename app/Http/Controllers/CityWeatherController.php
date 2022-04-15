<?php

namespace App\Http\Controllers;

use App\Clients\OpenWeatherMapClient;
use App\Dictionaries\CitiesDictionary;
use App\DtoFactories\SingleDayWeatherForecastDtoFactory;
use App\Exceptions\MissingArrayKeyException;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class CityWeatherController extends Controller
{
    /**
     * @var OpenWeatherMapClient
     */
    private $apiClient;

    /**
     * @var SingleDayWeatherForecastDtoFactory
     */
    private $forecastsFactory;

    public function __construct()
    {
        $this->apiClient = new OpenWeatherMapClient(new Client());
        $this->forecastsFactory = new SingleDayWeatherForecastDtoFactory();
    }

    public function chooseCity()
    {
        return view('ChooseCity', ['cities' => CitiesDictionary::getAllCities()]);
    }

    public function showWeather(Request $request)
    {
        $request->validate([
            'city' => 'required|in:'.implode(',', CitiesDictionary::getAllCities()),
        ]);

        $city = $request->get('city');

        if (!key_exists($city, CitiesDictionary::getCitiesToCoordinatesMap())) {
            throw new MissingArrayKeyException('City is not found in the coordinates mapping');
        }

        $coordinates = CitiesDictionary::getCitiesToCoordinatesMap()[$city];
        $data = $this->apiClient->getWeatherForcast($coordinates['lat'], $coordinates['lon']);
        $forecasts = $this->forecastsFactory->createFromRawData($data);

        return view('CityWeather', ['city' => $city, 'forecasts' => $forecasts]);
    }
}
