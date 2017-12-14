<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;
use App\User;
use App\Place;
use App\Helpers\WeatherHelper;
use App\Notifications\SendMessage;

class PreferencesController extends Controller
{

    public function store(Request $request) {

    	$errors = $request->validate([
    		'email' => 'required|unique:users|email',
            'max_temp' => 'min:-99|max:99|integer|nullable',
            'min_temp' => 'min:-99|max:99|integer|nullable',
            'radiation' => 'min:0|max:11|integer|nullable',
            'max_humidity' => 'min:0|max:100|integer|nullable',
            'min_humidity' => 'min:0|max:100|integer|nullable',
            'wind' => 'min:0|max:200|integer|nullable',
    	], [
    		'unique' => 'Adres e-mail jest zajęty.',
    		'required' => 'Adres e-mail jest polem wymaganym.',
    		'email' => 'Wpisany adres e-mail jest nieprawidłowy.',
            'min' => 'Min wartość to :min',
            'max' => 'Max wartość to :max',
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
        $errors = $request->validate([
            'max_temp' => 'min:-99|max:99|integer|nullable',
            'min_temp' => 'min:-99|max:99|integer|nullable',
            'radiation' => 'min:0|max:11|integer|nullable',
            'max_humidity' => 'min:0|max:100|integer|nullable',
            'min_humidity' => 'min:0|max:100|integer|nullable',
            'wind' => 'min:0|max:200|integer|nullable',
        ], [
            'min' => 'Min wartość to :min',
            'max' => 'Max wartość to :max',
        ]);

        if($request->cityName != null) {
            $Place = Place::where('name', $request->cityName)->first();
            if(!$Place) {
                $place_id = $this->addNewPlace($request->cityName, $request->lat, $request->lng);
            } else {
                $place_id = $Place->id;
            }
    	    $user->place_id = $place_id;
        }

		$user->max_temp = $request->max_temp;
		$user->min_temp = $request->min_temp;
		$user->max_humidity = $request->max_humidity;
        $user->min_humidity = $request->min_humidity;
		$user->wind = $request->wind;
		$user->radiation = $request->radiation;
		$user->save();

        $request->session()->flash('msg.status', 'success');
        $request->session()->flash('msg.content', 'Dane zostały zaktualizowane');

        return back();
    }

    private function createUser($request, $place_id) {

        $User = User::create([
            'email' => $request->email, 
            'place_id' => $place_id, 
            'max_temp' => $request->max_temp, 
            'min_temp' => $request->min_temp, 
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
