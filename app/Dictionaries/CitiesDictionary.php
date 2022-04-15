<?php

namespace App\Dictionaries;

class CitiesDictionary
{
    public const SYDNEY = 'Sydney';
    public const MELBOURNE = 'Melbourne';
    public const BRISBANE = 'Brisbane';

    /**
     * @return string[]
     */
    public static function getAllCities(): array
    {
        return [
            self::SYDNEY,
            self::MELBOURNE,
            self::BRISBANE,
        ];
    }

    public static function getCitiesToCoordinatesMap(): array
    {
        return [
            self::SYDNEY => ['lat' => '-33.768528', 'lon' => '150.9568559523945'],
            self::MELBOURNE => ['lat' => '-37.8142176', 'lon' => '144.9631608'],
            self::BRISBANE => ['lat' => '-27.4689682', 'lon' => '153.0234991'],
        ];
    }
}
