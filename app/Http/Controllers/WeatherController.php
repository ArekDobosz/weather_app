<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Helpers\WeatherHelper;
use App\Place;

class WeatherController extends Controller
{
    public function update($lat, $lng, $city) {

    	if(Cache::has($city)) {
            return response()->json(Cache::get($city));
        }

    	$weather = WeatherHelper::getWeatherData($lat, $lng);

    	$details = [
    		'city' => $city,
            'lat' => $lat,
            'lng' => $lng,
    		'icon' => $weather->currently->icon,
    		'temperature' => WeatherHelper::toCelsius($weather->currently->temperature),
    		'humidity' => $weather->currently->humidity * 100,
    		'wind' => $weather->currently->windSpeed,
    		'uvIndex' => $weather->currently->uvIndex
    	];

    	$data = Cache::remember($city, 120, function () use ($details) {
    		return $details;
    	});

    	return response()->json($data);  	
    }
}
