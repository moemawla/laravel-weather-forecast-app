<?php

namespace App\Dto;

class SingleDayWeatherForecastDto
{
    /**
     * @var float
     */
    private $minTemperature;

    /**
     * @var float
     */
    private $maxTemperature;

    public function __construct(float $minTemperature, float $maxTemperature)
    {
        $this->minTemperature = $minTemperature;
        $this->maxTemperature = $maxTemperature;
    }

    public function getMinTemperature(): float
    {
        return $this->minTemperature;
    }

    public function getMaxTemperature(): float
    {
        return $this->maxTemperature;
    }
}
