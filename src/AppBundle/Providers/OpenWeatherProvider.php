<?php

namespace AppBundle\Providers;

use AppBundle\Exceptions\WeatherException;
use AppBundle\ApiCall;
use AppBundle\Providers\WeatherProviderInterface;

class OpenWeatherProvider implements WeatherProviderInterface
{
    /**
     * @var string The basic api url to fetch weather data from.
     */
    private $baseUrl = 'http://api.openweathermap.org/data/2.5/weather?';

    /**
     * @var string OpenWeather API key
     */
    private $owm_apikey;

    public function __construct($owm_apikey)
    {
        $this->owm_apikey = $owm_apikey;
    }

    /**
     * Call to OpenWeather API
     * @param $location
     * @throws WeatherException
     * @return int
     */
    public function fetch($location)
    {
        $fullUrl = $this->baseUrl . 'q=' . $location . '&units=metric&APPID=' . $this->owm_apikey;
        $phpObj = ApiCall::getData($fullUrl);
        $temp = $phpObj->main->temp ?? null;

        if ($temp === null)
            throw new WeatherException('Unable to fetch weather from OpenWeather');

        return $temp;
    }
}
