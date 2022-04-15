<?php

namespace Tests\Unit;

use App\Dto\SingleDayWeatherForecastDto;
use App\DtoFactories\SingleDayWeatherForecastDtoFactory;
use App\Exceptions\MissingArrayKeyException;
use PHPUnit\Framework\TestCase;

class SingleDayWeatherForecastDtoFactoryTest extends TestCase
{
    private const KELVIN_TEMP_OFFSET = 273.15;

    /**
     * @var SingleDayWeatherForecastDtoFactory
     */
    private $forecastFactory;

    public function setUp(): void
    {
        $this->forecastFactory = new SingleDayWeatherForecastDtoFactory();
    }

    public function testFailureOnDailyKeyNotExisting()
    {
        $data = [];

        $this->expectException(MissingArrayKeyException::class);
        $this->expectExceptionMessage('Key "daily" is not found');
        $this->forecastFactory->createFromRawData($data);
    }

    public function testFailureOnTempKeyNotExisting()
    {
        $data = [
            'daily' => [
                ["humidity"=>22,"dew_point"=>267.23,"wind_speed"=>7.63,"wind_deg"=>192,"wind_gust"=>14.65]
            ]
        ];

        $this->expectException(MissingArrayKeyException::class);
        $this->expectExceptionMessage('Key "temp" is not found');
        $this->forecastFactory->createFromRawData($data);
    }

    public function testFailureOnMinKeyNotExisting()
    {
        $data = [
            'daily' => [
                ["temp"=>["day"=>289.91,"max"=>291.97,"night"=>288.03,"eve"=>291.24,"morn"=>283.97]]
            ]
        ];

        $this->expectException(MissingArrayKeyException::class);
        $this->expectExceptionMessage('Key "min/max" is not found');
        $this->forecastFactory->createFromRawData($data);
    }

    public function testFailureOnMaxKeyNotExisting()
    {
        $data = [
            'daily' => [
                ["temp"=>["day"=>289.91,"min"=>283.68,"night"=>288.03,"eve"=>291.24,"morn"=>283.97]]
            ]
        ];

        $this->expectException(MissingArrayKeyException::class);
        $this->expectExceptionMessage('Key "min/max" is not found');
        $this->forecastFactory->createFromRawData($data);
    }

    public function testSuccessfulCreation()
    {
        $data = [
            'daily' => [
                ["temp"=>["min"=>283.68,"max"=>291.97]],
                ["temp"=>["min"=>283.68,"max"=>291.97]],
                ["temp"=>["min"=>283.68,"max"=>291.97]],
                ["temp"=>["min"=>283.68,"max"=>291.97]],
                ["temp"=>["min"=>283.68,"max"=>291.97]],
                ["temp"=>["min"=>283.68,"max"=>291.97]],
            ]
        ];

        $forecasts = $this->forecastFactory->createFromRawData($data);

        $this->assertCount(5, $forecasts);

        foreach ($forecasts as $forecast) {
            $this->assertInstanceOf(SingleDayWeatherForecastDto::class, $forecast);
            $this->assertEquals((283.68 - self::KELVIN_TEMP_OFFSET), $forecast->getMinTemperature());
            $this->assertEquals((291.97 - self::KELVIN_TEMP_OFFSET), $forecast->getMaxTemperature());
        }
    }
}
