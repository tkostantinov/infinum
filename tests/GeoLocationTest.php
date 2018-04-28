<?php


use Infinum\GeoLocation;

class GeoLocationTest extends \PHPUnit_Framework_TestCase
{
    public function testGetCoordinatesForAddress()
    {
        $geoLocation = new GeoLocation("AIzaSyDsMAGgfdkYsLCMLaPYpHSfs1JdQO_4AuA");

        $location = $geoLocation->getCoordinates("Zagreb");

        $zagrebLocation = new stdClass();

        $zagrebLocation->lat = 45.8150108;
        $zagrebLocation->lng = 15.9819189;

        $this->assertEquals($location->lat, $zagrebLocation->lat, "Latitude is invalid");
        $this->assertEquals($location->lng, $zagrebLocation->lng, "Longitude is invalid");
    }
}