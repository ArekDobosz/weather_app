<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\WeatherHelper;
use App\Place;

class WeatherController extends Controller
{
    // public function update($lat, $lng) {

    // 	$data = WeatherHelper::getWeatherData(53.778422, 20.4801192);

    // 	var_dump($data->currently);  	
    // }

    public function update() {

    	$users = WeatherHelper::createNotifications();
    	die(var_dump($users));
    }
}
