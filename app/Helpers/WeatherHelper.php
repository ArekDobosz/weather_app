<?php

namespace App\Helpers;

class WeatherHelper 
{
	public static function getWeatherData($lat, $lng)
	{
		//"https://api.darksky.net/forecast/8676a9ca8d3ed7e785fb490ee18b6635/53.778422,20.4801192"
		$url = "https://api.darksky.net/forecast/8676a9ca8d3ed7e785fb490ee18b6635/".$lat.",".$lng;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$data = curl_exec($ch);
		curl_close($ch);

		return  json_decode($data);		
	}
}