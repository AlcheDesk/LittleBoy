<?php
namespace App\Services;

use Illuminate\Support\Facades\Log;
use Torann\GeoIP\Facades\GeoIP;

class GeoIPService {
    
    private static $ip;
    private static $location;
    private static $ipInfo; 

    public function file_get_contents_curl( $url ) {
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_AUTOREFERER, TRUE );
        curl_setopt( $ch, CURLOPT_HEADER, 0 );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, TRUE );

        $data = curl_exec( $ch );
        curl_close( $ch );

        return $data;
    }
    
    public function getApplicationIP (){        
        if(!empty($this->file_get_contents_curl('https://api.ipify.org'))){
            $ipInfo =$this->file_get_contents_curl('https://api.ipify.org');    
        } else{
            $ipInfo = "127.0.0.1";
        }       
        if (!isset(GeoIPService::$ip)){
            GeoIPService::$ip = $ipInfo;
        }  
        Log::info("Application current ip is ".GeoIPService::$ip);
        return GeoIPService::$ip;
    }
    
    public function getApplicationGeoInfo(){
        if (!isset(GeoIPService::$location)){
            $currentIP = $this->getApplicationIP();
            GeoIPService::$location = GeoIP::getLocation($currentIP);            
        }   
        Log::info("Application current location info".json_encode(GeoIPService::$location));
        return GeoIPService::$location;
    }
    
}