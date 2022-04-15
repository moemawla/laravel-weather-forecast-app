<?php

namespace Tests\Unit;

use App\Clients\OpenWeatherMapClient;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class OPenWeatherMapClientTest extends TestCase
{
    private const WEATHER_FORECAST_URL = 'https://api.openweathermap.org/data/2.5/onecall?lat=%s&lon=%s&appid=%s';

    /**
     * @var ObjectProphecy|Client
     */
    private $guzzleClient;

    /**
     * @var string
     */
    private $lat;

    /**
     * @var string
     */
    private $lon;

    /**
     * @var string
     */
    private $appId;

    /**
     * @var array
     */
    private $data;

    /**
     * @var ObjectProphecy|ResponseInterface
     */
    private $response;

    /**
     * @var ObjectProphecy|StreamInterface
     */
    private $stream;

    public function setUp(): void
    {
        $this->guzzleClient = $this->prophesize(Client::class);
        $this->lat = '-33.768528';
        $this->lon = '150.9568559523945';
        $this->appId = env('OPEN_WEATHER_APP_ID');
        $this->data = '{"daily":[{"temp":{"min":283.68,"max":291.97}},{"temp":{"min":283.68,"max":291.97}}]}';
        $this->response = $this->prophesize(ResponseInterface::class);
        $this->stream = $this->prophesize(StreamInterface::class);
    }

    public function testApiResponseIsSuccessfullyDecoded()
    {
        $this->stream
            ->getContents()
            ->shouldBeCalled()
            ->willReturn($this->data);

        $this->response
            ->getBody()
            ->shouldBeCalled()
            ->willReturn($this->stream->reveal());

        $this->guzzleClient
            ->get(sprintf(self::WEATHER_FORECAST_URL, $this->lat, $this->lon, $this->appId))
            ->shouldBeCalled()
            ->willReturn($this->response->reveal());

        $client = new OpenWeatherMapClient($this->guzzleClient->reveal());
        $forecastData = $client->getWeatherForcast($this->lat, $this->lon);
        $this->assertEquals(json_decode($this->data, true), $forecastData);
    }
}
