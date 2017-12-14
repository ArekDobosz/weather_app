<?php

namespace App\Helpers;

use App\Place;
use App\User;


class WeatherHelper 
{
	// https://api.darksky.net/forecast/8676a9ca8d3ed7e785fb490ee18b6635/54.03640499999999,21.7667342
	// https://api.darksky.net/forecast/8676a9ca8d3ed7e785fb490ee18b6635/lat=54.03640499999999,lng=21.7667342"
	public static function getWeatherData($lat, $lng)
	{
		$url = "https://api.darksky.net/forecast/8676a9ca8d3ed7e785fb490ee18b6635/".$lat.",".$lng;
		// die(var_dump($url));
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$data = curl_exec($ch);
		curl_close($ch);

		return  json_decode($data);		
	}

	public static function update() {

    	$places = Place::all();
    	$params = [];
    	
    	foreach($places as $place) {
    		array_push($params, [
    			'id' => $place->id,
    			'lat' => $place->lat,
    			'lng' => $place->lng
    		]);
    	}
    	$data = self::updateWeather($params);

    	foreach($data as $place) {
    		$temp = self::toCelsius($place['temp']);

    		Place::find($place['id'])
    			->update([
    				'temperature' => $temp,
    				'humidity' => $place['humidity'],
    				'wind' => $place['windSpeed'],
    				'radiation' => $place['uvIndex'],
    				'icon' => $place['icon'],
    			]);
    	}
	}

	public static function updateWeather($params = []) {
		
		foreach($params as $place) {
			$data = self::getWeatherData($place['lat'], $place['lng']);
			$places[] = [
				'id' => $place['id'],
				'icon' => $data->currently->icon,
				'temp' => $data->currently->temperature,
				'humidity' => $data->currently->humidity * 100,
				'windSpeed' => $data->currently->windSpeed,
				'uvIndex' => $data->currently->uvIndex,
				// 'rainfall' => $data->currently->precipType
			];
		}
		return $places;
	}

	public static function createNotifications() {

		$users = User::with('place')->get();
		$max_temperature = $min_temperature = $max_humidity = $min_humidity = $wind = $radiation = $index = $msg = '';
		$temp = [];

		foreach($users as $user) {
			
			$notify = false;
			if(isset($user->max_temp) && $user->max_temp < $user->place->temperature) {
				$max_temperature = "maksymalna temperatura przekroczyła {$user->max_temp} i wynosi {$user->place->temperature}, ";
				$notify = true;
			}
			if(isset($user->min_temp) && $user->min_temp > $user->place->temperature) {
				$min_temperature = "temperatura minimalna spdadła poniżej progu {$user->min_temp} i wynosi {$user->place->temperature}, ";
				$notify = true;
			}
			if(isset($user->max_humidity) && $user->max_humidity < $user->place->humidity) {
				$max_humidity = "wilgotność powietrza przekroczyła {$user->max_humidity}% i wynosi {$user->place->humidity}%, ";
				$notify = true;
			}
			if(isset($user->min_humidity) && $user->min_humidity > $user->place->humidity) {
				$min_humidity = "wilgotność powietrza spadła poniżej {$user->min_humidity}% i wynosi {$user->place->humidity}%, ";
				$notify = true;
			}
			if(isset($user->wind) && $user->wind < $user->place->wind) {
				$wind = "prędkość wiatru przekroczyła {$user->wind}m/s i wynosi {$user->place->wind}m/s, ";
				$notify = true;
			}
			if(isset($user->radiation) && $user->radiation < $user->place->radiation) {
				$index = "indeks UV przekroczył {$user->radiation} i wynosi {$user->place->radiation}, ";
				$notify = true;
			}
			if($notify) {
				$msg = "Użytkowniku {$user->email} w miejscowości {$user->place->name}, {$max_temperature}{$min_temperature}{$max_humidity}{$min_humidity}{$wind}{$index}pozdrawiamy zespół weather_app";
			}
			$temp[$user->email] = $msg;
		}	
		return $temp;
	}

	public static function toCelsius($temp) {
		return floor((($temp - 32) / 1.8) * 10) / 10;
	}
}