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

        if(!$Place) {
            $place_id = $this->addNewPlace($request->cityName, $request->lat, $request->lng);
        } else {
            $place_id = $Place->id;
        }

		$token = $this->createUser($request, $place_id);

    	Notification::route('mail', $request->email)
    		->notify(new SendMessage($token));

    	return response()->json('Preferencje zostały dodane', 201);
    }

    public function edit($token)
    {
    	$user = User::where('token', $token)->with('place')->first();
    	if(!$user) {
    		abort(403);
    	}
    	return view('user.edit', compact('user'));
    }

    public function update(Request $request, $token)
    {
        $user = User::where('token', $token)->first();
        if(!$user) {
            abort(400);
        }

        if($request->cityName != null) {
            $Place = Place::where('name', $request->cityName)->first();
            if(!$Place) {
                $place_id = $this->addNewPlace($request->cityName, $request->lat, $request->lng);
            } else {
                $place_id = $Place->id;
            }
    	    $user->place_id = $place_id;
        }

		$user->max_temperature = $request->max_temperature;
		$user->min_temperature = $request->min_temperature;
		$user->max_humidity = $request->max_humidity;
		$user->wind = $request->wind;
		$user->radiation = $request->radiation;

		$user->save();

        return back();
    }

    private function createUser($request, $place_id) {

        $User = User::create([
            'email' => $request->email, 
            'place_id' => $place_id, 
            'max_temperature' => $request->max_temp, 
            'min_temperature' => $request->min_temp, 
            'max_humidity' => $request->max_humidity, 
            'min_humidity' => $request->min_humidity, 
            'wind' => $request->wind, 
            'radiation' =>$request->radiation, 
            'token' => uniqid(sha1(rand(1,100)))
        ]);
        return $User->token;
    }

    private function addNewPlace($name, $lat, $lng)
    {
        $data = WeatherHelper::getWeatherData($lat, $lng);

        $temp = floor((($data->currently->temperature - 32) / 1.8) * 10) / 10;

        $Place = Place::create([
            'name' => $name,
            'lat' => $lat,
            'lng' => $lng,
            'temperature' => $temp,
            'humidity' => $data->currently->humidity * 100,
            'wind' => $data->currently->windSpeed,
            'radiation' => $data->currently->uvIndex,
            'icon' => $data->currently->icon
        ]);

        return $Place->id;
    }
}
