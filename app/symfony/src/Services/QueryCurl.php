<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\JsonResponse;

Class QueryCurl {

    public $vendor_token;
    public $currency;

    public function __construct() {
        $this->vendor_token = '5a8408cf3c97a473374652';
        $this->currency = 'EUR';
    }

    /**
     * @Var $url (string)
     **/
    public function getQuery($url) {
        //Initialize cURL.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $data = curl_exec($ch);
        curl_close($ch);

        //return value on page (array or json)
        return $data;
    }

    /**
     * @Var $url (string)
     * @Var $datas (array)
     **/
    public function postQuery($url, $datas) {
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($datas));
        $data = curl_exec($ch);
        curl_close($ch);

        //return value on page (array or json)
        return $data;
    }
}