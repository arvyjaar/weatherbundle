<?php

namespace AppBundle\Providers;

use AppBundle\Exceptions\WeatherException;
use AppBundle\Providers\WeatherProviderInterface;
use AppBundle\ApiCall;

class ApixuWeatherProvider implements WeatherProviderInterface
{
    /**
     * @var string The basic api url to fetch weather data from.
     */
    private $apixu_apikey;

    /**
     * @var string Apixu Weather API key
     */
    private $baseUrl = "http://api.apixu.com/v1/current.json?key=";

    public function __construct($apixu_apikey)
    {
        $this->apixu_apikey = $apixu_apikey;
    }

    /**
     * Call to Apixu API
     * @param string $location
     * @throws WeatherException
     * @return int
     */
    public function fetch($location)
    {
        $fullUrl = $this->baseUrl . $this->apixu_apikey . "&q=" . $location;
        $phpObj = ApiCall::getData($fullUrl);
        $temp = $phpObj->current->temp_c ?? null;

        if ($temp === null)
            throw new WeatherException('Unable to fetch weather from ApixuWeather');

        return $temp;
    }
}
