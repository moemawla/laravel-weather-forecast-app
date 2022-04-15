<?php

namespace App\DtoFactories;

use App\Dto\SingleDayWeatherForecastDto;
use App\Exceptions\MissingArrayKeyException;

class SingleDayWeatherForecastDtoFactory
{
    private const KELVIN_TEMP_OFFSET = 273.15;
    private const NUMBER_OF_DAYS_TO_FORECAST = 5;

    /**
     * @param mixed $data
     * @throws MissingArrayKeyException
     * @return SingleDayWeatherForecastDto[]
     */
    public function createFromRawData(array $data): array
    {
        if (!key_exists('daily', $data)) {
            throw new MissingArrayKeyException('Key "daily" is not found');
        }

        $forecasts = [];
        $count = 0;
        foreach ($data['daily'] as $dailyData) {
            if (self::NUMBER_OF_DAYS_TO_FORECAST === $count) {
                break;
            }

            $forecasts[] = $this->createOne($dailyData);
            $count++;
        }

        return $forecasts;
    }

    /**
     * @param mixed $dailyData
     * @throws MissingArrayKeyException
     */
    private function createOne(array $dailyData): SingleDayWeatherForecastDto
    {
        if (!key_exists('temp', $dailyData)) {
            throw new MissingArrayKeyException('Key "temp" is not found');
        }

        $temperatures = $dailyData['temp'];

        if (!key_exists('min', $temperatures) || !key_exists('max', $temperatures)) {
            throw new MissingArrayKeyException('Key "min/max" is not found');
        }

        $minTemperature = ((float) $temperatures['min']) - self::KELVIN_TEMP_OFFSET;
        $maxTemperature = ((float) $temperatures['max']) - self::KELVIN_TEMP_OFFSET;

        return new SingleDayWeatherForecastDto($minTemperature, $maxTemperature);
    }
}
