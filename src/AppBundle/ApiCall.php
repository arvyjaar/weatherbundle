<?php

namespace AppBundle;

class ApiCall
{
    /**
     * Get data from weather API
     * @param string $fullUrl
     * @return object
     */
    public static function getData($fullUrl)
    {
        $session = curl_init($fullUrl);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($session);
        $phpObj = json_decode($json);
        return $phpObj;
    }
}