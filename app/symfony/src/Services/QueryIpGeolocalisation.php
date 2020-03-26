<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class QueryIpGeolocalisation
{

    const LOCATOR_URI = "http://ip-api.com/json/";
    const GEOLOCATOR_API = "http://www.geoplugin.net/php.gp?ip=";


    /**
     * @param string $ip
     * @return mixed
     */
    public function getIpLocator(string $ip){

        $url = self::LOCATOR_URI.$ip;
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $output=curl_exec($ch);
        curl_close($ch);

        return json_decode($output, TRUE);

    }

    /**
     * @param $ipAddresse
     * @return array
     */
    public function userGeoLocator($ipAddresse): array {
        //Récuperation de l'adresse IP du client
        $geoplugin = unserialize( file_get_contents(self::GEOLOCATOR_API.$ipAddresse) );
        if ( is_numeric($geoplugin['geoplugin_latitude']) && is_numeric($geoplugin['geoplugin_longitude']) ) {
            $lat = $geoplugin['geoplugin_latitude'];
            $long = $geoplugin['geoplugin_longitude'];
        }else{
            $lat = "0.1";
            $long = "0.1";
        }

        //$geoplugin = json_decode( file_get_contents(self::LOCATOR_URI.$ipAddresse) , 1);

        if(isset($geoplugin['city'])) {
            $city = $geoplugin['city'];
            $cp = $geoplugin['zip'];
            $country = $geoplugin['country'];
        }else{
            $city = "-";
            $cp = "-";
            $country = "-";
        }

        return [
            'geodata_ip' => $ipAddresse,
            'geodata_lat' => $lat,
            'geodata_long' => $long,
            'geodata_city' => $city,
            'geodata_cp' => $cp,
            'geodata_country' => $country
        ];
    }

}