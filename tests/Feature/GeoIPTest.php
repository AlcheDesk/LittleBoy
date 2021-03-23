<?php

namespace Tests\Feature;

use Tests\TestCase;
use Torann\GeoIP\Facades\GeoIP;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\GeoIPService;

class GeoIPTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $location = GeoIP::getLocation();
        var_dump($location);
        
        $service = new GeoIPService();
        $location2 = $service->getApplicationGeoInfo();
        var_dump($location2);
        $ip = $service->getApplicationIP();
        $this->assertEquals($location, $location2);
    }
}
