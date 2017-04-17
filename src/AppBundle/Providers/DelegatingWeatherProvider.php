<?php

namespace AppBundle\Providers;

use AppBUndle\Exceptions\WeatherException;
use AppBundle\Providers\WeatherProviderInterface;
use Symfony\Component\Config\Definition\Exception\Exception;


class DelegatingWeatherProvider implements WeatherProviderInterface
{
    /**
     * Weather providers array
     * @var array
     */
    private $provider1;
    private $provider2;

    public function __construct($provider1, $provider2)
    {
        $this->provider1 = $provider1;
        $this->provider2 = $provider2;
    }

    /**
     * @param $location
     * @return int
     * @throws WeatherException
     * @throws \Exception
     */
    public function fetch($location)
    {
        try {
            $weather = $this->provider1->fetch($location);
        } catch (WeatherException $e) {
            // if 1-st throws exception, do:
            try {
                $weather = $this->provider2->fetch($location);
            } catch (WeatherException $e) {
                // if 2-nd throws exception too, throw Exception
                throw new \Exception('Unable fetch data from both sources');
            }
            echo "Result from: " . get_class($this) . ' through ' . get_class($this->provider2);
            return $weather;
        }
        echo "Result from: " . get_class($this) . ' through ' . get_class($this->provider1);
        return $weather;

    }
}
