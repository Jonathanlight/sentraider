<?php

namespace App\Services;

class LocationUserAnnonymeService
{
    const URL_LOCATION = "http://ip-api.com/json/";

    /**
     * @param string $ip
     * @return mixed
     */
    public function getIpDetail(string $ip)
    {
        $ip_response = file_get_contents(LocationUserAnnonymeService::URL_LOCATION.$ip);

        return  json_decode($ip_response);
    }
}