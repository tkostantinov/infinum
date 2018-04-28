<?php

namespace Infinum\Service;


class GeoLocation
{
    private $url = "https://maps.googleapis.com/maps/api/geocode/json";
    private $apiKey;

    public function __construct($apiKey){
        $this->apiKey = $apiKey;
    }

    public function getCoordinates($address){

        $params = [
            "address" => $address,
            "key" => $this->apiKey
        ];

        $urlWithParams = $this->url . "?" . http_build_query($params);

        $content = file_get_contents($urlWithParams);
        $response = json_decode($content);

        return $response->results[0]->geometry->location;
    }
}
