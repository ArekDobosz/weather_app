<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\WeatherHelper;
use App\Place;

class WeatherController extends Controller
{
    public function update() {

    	$users = WeatherHelper::createNotifications();
    	die(var_dump($users));
    }
}
