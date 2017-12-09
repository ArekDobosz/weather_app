<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Place;
use App\Helpers\WeatherHelper;

class PreferencesController extends Controller
{
    public function store(Request $request) {

    	$errors = $request->validate([
    		'email' => 'required|unique:users|email'
    	], [
    		'unique' => 'Adres e-mail jest zajęty.'
    	]);

    	$Place = Place::where('name', $request->cityName)->first();
    	if (!$Place) {

    		$data = WeatherHelper::getWeatherData($request->lat, $request->lng);

    		$Place = Place::create([
    			'name' => $request->cityName,
    			'lat' => $request->lat,
    			'lng' => $request->lng,
    			'temperature' => floor((($data->currently->temperature - 32) / 1.8) * 10) / 10,
    			'humidity' => $data->currently->humidity * 100,
    			'wind' => $data->currently->windSpeed,
    			'radiation' => $data->currently->uvIndex,
    			'icon' => $data->currently->icon
    		]);
    	}
    	
    	$User = User::where('email', $request->email)->first();

    	if (!$User) {
    		// return response()->json('Preferencje zostały utworzone', 201);
    		$User = User::create([
    			'email' => $request->email, 
    			'place_id' => $Place->id, 
    			'max_temperature' => $request->max_temp, 
    			'min_temperature' => $request->min_temp, 
    			'max_humidity' => $request->max_humidity, 
    			'min_humidity' => $request->min_humidity, 
    			'wind' => $request->wind, 
    			'radiation' =>$request->radiation, 
    			'token' => uniqid(sha1(true))
    		]);

    		return response()->json('Preferencje zostały utworzone', 201);
    	} else {
    		$User->place_id = $Place->id;
    		$User->max_temperature = $request->max_temperature;
    		$User->min_temperature = $request->min_temperature;
    		$User->max_humidity = $request->max_humidity;
    		$User->wind = $request->wind;
    		$User->radiation = $request->radiation;

    		$User->save();
    	}

    	// die(var_dump($Place));

    	return response()->json('', 201);
    }
}
