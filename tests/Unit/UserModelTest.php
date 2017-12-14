<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\{User, Place};

class UserModelTest extends TestCase
{
	use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserCreate()
    {
        $place = Place::create([
        	'name' => 'Giżycko',
        	'lat' => 54.03,
        	'lng' => 21.76
        ]);

        $user = User::create([
        	'email' => 'example@example.com',
        	'place_id' => 1,
        	'max_temperature' => 20,
        	'min_temperature' => -5,
        	'max_humidity' => 85,
        	'min_humidity' => 40,
        	'wind' => 20.7,
        	'radiation' => 3
        ]);

        $foundedUser = User::find(1);
        $foundedPlace = Place::find(1);

        $this->assertEquals($user->email, $foundedUser->email);
        $this->assertEquals($user->place->name, $foundedPlace->name);
        $this->assertEquals($user->max_temperature, $foundedUser->max_temperature);
        $this->assertEquals($user->min_temperature, $foundedUser->min_temperature);
        $this->assertEquals($user->max_humidity, $foundedUser->max_humidity);
        $this->assertEquals($user->min_humidity, $foundedUser->min_humidity);
        $this->assertEquals($user->wind, $foundedUser->wind);
        $this->assertEquals($user->radiation, $foundedUser->radiation);

        // $user2 = User::create([
        //     'email' => 'example@example.com'
        // ]);
        // $this->seeStatusCode(422);
    }
}
