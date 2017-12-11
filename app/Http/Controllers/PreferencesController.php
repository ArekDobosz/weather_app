<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Place;
use App\Helpers\WeatherHelper;
use App\Notifications\SendMessage;
use Illuminate\Support\Facades\Notification;

class PreferencesController extends Controller
{

    public function store(Request $request) {

    	$errors = $request->validate([
    		'email' => 'required|unique:users|email'
    	], [
    		'unique' => 'Adres e-mail jest zajęty.',
    		'required' => 'Adres e-mail jest polem wymaganym.',
    		'email' => 'Wpisany adres e-mail jest nieprawidłowy.'
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
    	
    	// $User = User::where('email', $request->email)->first();

    	// if (!$User) {
    		$User = User::create([
    			'email' => $request->email, 
    			'place_id' => $Place->id, 
    			'max_temperature' => $request->max_temp, 
    			'min_temperature' => $request->min_temp, 
    			'max_humidity' => $request->max_humidity, 
    			'min_humidity' => $request->min_humidity, 
    			'wind' => $request->wind, 
    			'radiation' =>$request->radiation, 
    			'token' => uniqid(sha1(rand(1,100)))
    		]);
    	// }

    	Notification::route('mail', $request->email)
    		->notify(new SendMessage($User->token));

    	return response()->json('Preferencje zostały dodane', 201);
    }

    public function edit($token)
    {
    	$user = User::where('token', $token)->with('place')->first();
    	if(!$user) {
    		abort(404);
    	}
    	return view('user.edit', compact('user'));
    }

    public function update()
    {
    	$User->place_id = $Place->id;
    		$User->max_temperature = $request->max_temperature;
    		$User->min_temperature = $request->min_temperature;
    		$User->max_humidity = $request->max_humidity;
    		$User->wind = $request->wind;
    		$User->radiation = $request->radiation;

    		$User->save();
    }
}
