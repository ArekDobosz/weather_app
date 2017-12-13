<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Place;

class PlaceModelTest extends TestCase
{
	use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPlaceCreate()
    {
        $place = Place::create([
        	'name' => 'Giżycko',
        	'lat' => 54.03,
        	'lng' => 21.76,
        	'temperature' => 20.5,
        	'humidity' => 85,
        	'wind' => 12.7,
        	'radiation' => 1
        ]);

        $foundedPlace = Place::find(1);

        $this->assertEquals($place->name, $foundedPlace->name);
        $this->assertEquals($place->lat, $foundedPlace->lat);
        $this->assertEquals($place->lng, $foundedPlace->lng);
        $this->assertEquals($place->temperature, $foundedPlace->temperature);
        $this->assertEquals($place->humidity, $foundedPlace->humidity);
        $this->assertEquals($place->wind, $foundedPlace->wind);
        $this->assertEquals($place->radiation, $foundedPlace->radiation);
    }
}
