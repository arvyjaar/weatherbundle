<?php

namespace AppBundle\Providers;

use Symfony\Component\Cache\CacheItem;
use AppBundle\Providers\WeatherProviderInterface;
use AppBundle\Exceptions\WeatherException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class CachedWeatherProvider implements WeatherProviderInterface
{
    private $lifetime;
    private $weatherProvider;

    public function __construct($lifetime, $weatherProvider)
    {
        $this->lifetime = $lifetime;
        $this->weatherProvider = $weatherProvider;
    }

    public function fetch($location)
    {
        $location_key = strtolower($location);

        try {
            CacheItem::validateKey($location_key);
        } catch (\InvalidArgumentException $e) {
            // Maybe here I should not call to API at all, it depends...

            //$weather = $this->weatherProvider->fetch($location);
            //return $weather;
        }

        $cache = new FilesystemAdapter(
            $namespace = '',
            // in seconds; applied to cache items that don't define their own lifetime
            $defaultLifetime = $this->lifetime,
            // the main cache directory
            $directory = 'SymfonyCache'
        );

        $data = $cache->getItem($location_key);

        try {
            $weather = $data->get();
            if ($weather === null) {
                throw new WeatherException('Unable fetch data from Cache');
            }
            echo "Result from cache";
            return $weather;
        } catch (WeatherException $e) {
            $weather = $this->weatherProvider->fetch($location);

            // I think it isn't good get and set data in the same method :-/
            $data->set(
                $weather
            );
            $cache->save($data);

            echo "Result from: " . get_class($this->weatherProvider);
            return $weather;
        }
    }
}
