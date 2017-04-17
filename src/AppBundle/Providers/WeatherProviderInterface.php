<?php

namespace AppBundle\Providers;

interface WeatherProviderInterface
{
    public function fetch($location);
}