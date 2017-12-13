<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Helpers\WeatherHelper;
use App\{User, Place};

class WeatherHelperTest extends TestCase
{
	use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $place = Place::create([
        	'name' => 'Giżycko',
        	'lat' => 54.03,
        	'lng' => 21.76,
        	'temperature' => 20.5,
        	'humidity' => 84,
        	'wind' => 10.7,
        	'radiation' => 1
        ]);

        $user = User::create([
        	'email' => 'example@example.com',
        	'place_id' => 1,
        	'max_temperature' => 20,
        	'min_temperature' => -5,
        	'max_humidity' => 85,
        	'min_humidity' => 40,
        	'wind' => 15.7,
        	'radiation' => 1
        ]);

        $result = WeatherHelper::createNotifications();

        $this->assertEquals([
        	"{$user->email}" => "Użytkowniku {$user->email} w miejscowości {$user->place->name}, maksymalna temperatura została przekroczona i wynosi {$user->place->temperature}, pozdrawiamy zespół weather_app"
        ], $result);


        $place2 = Place::create([
        	'name' => 'Węgorzewo',
        	'lat' => 54.03,
        	'lng' => 21.46,
        	'temperature' => 23.5,
        	'humidity' => 30,
        	'wind' => 10.7,
        	'radiation' => 4
        ]);

        $user2 = User::create([
        	'email' => 'example@example.net',
        	'place_id' => 2,
        	'max_temperature' => 20,
        	'min_temperature' => -5,
        	'max_humidity' => 85,
        	'min_humidity' => 40,
        	'wind' => 5,
        	'radiation' => 3
        ]);

        $result2 = WeatherHelper::createNotifications();

        $this->assertEquals(
        	"Użytkowniku {$user2->email} w miejscowości {$user2->place->name}, maksymalna temperatura została przekroczona i wynosi 23.5, wilgotność powietrza spadła poniżej 40% i wynosi 30%, prędkość wiatru przekroczyła 5m/s i wynosi 10.7m/s, indeks UV przekroczył 3 i wynosi 4, pozdrawiamy zespół weather_app"
        , $result2[$user2->email]);
    }
}
