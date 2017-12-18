<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;
use App\User;
use App\Place;
use App\Helpers\WeatherHelper;
use App\Notifications\SendMessage;
use App\Http\Requests\StoreUser;
use App\Http\Requests\EditUser;

class PreferencesController extends Controller
{

    public function store(StoreUser $request) {

        $place_id = $this->checkPlace($request->cityName, $request->lat, $request->lng);

        $token = $this->createUser($request, $place_id);

    	Notification::route('mail', $request->email)
    		->notify(new SendMessage($token));

    	return response()->json('Preferencje zostały dodane', 201);
    }

    public function edit($token)
    {
    	$user = User::where('token', $token)->with('place')->first();
    	if(!$user) {
    		abort(403, 'Brak dostępu do opcji.');
    	}
    	return view('user.edit', compact('user'));
    }

    public function update(EditUser $request, $token)
    {
        $user = User::where('token', $token)->first();
        if(!$user) {
            abort(403);
        }

        if($request->cityName != null) {
    	    $user->place_id = $place_id = $this->checkPlace($request->cityName, $request->lat, $request->lng);
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
                
        $temp = WeatherHelper::toCelsius($data->currently->temperature);

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

    private function checkPlace($name, $lat, $lng)
    {
        $Place = Place::where('name', $name)->first();

        if(!$Place) {
            $place_id = $this->addNewPlace($name, $lat, $lng);
        } else {
            $place_id = $Place->id;
        }

        return $place_id;
    }
}
