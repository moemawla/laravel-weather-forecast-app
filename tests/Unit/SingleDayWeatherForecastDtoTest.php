<?php

namespace Tests\Unit;

use App\Dto\SingleDayWeatherForecastDto;
use PHPUnit\Framework\TestCase;

class SingleDayWeatherForecastDtoTest extends TestCase
{
    public function testValuesAreSuccessfullyRetrieved()
    {
        $dto = new SingleDayWeatherForecastDto(15.5, 21.9);
        $this->assertEquals(15.5, $dto->getMinTemperature());
        $this->assertEquals(21.9, $dto->getMaxTemperature());
    }
}
