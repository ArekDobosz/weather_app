<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\{User, Place};

class PreferencesControllerTest extends TestCase
{
	use DatabaseMigrations;


	/**
     * A basic test example.
     *
     * @return void
     */
	public function testPreferencesMethodEdit()
	{
		$place = Place::create([
        	'name' => 'Giżycko',
        	'lat' => 54.03,
        	'lng' => 21.76
        ]);

        $user = User::create([
        	'email' => 'example@example.com',
        	'place_id' => 1,
        	'token' => 'eb4ac3033e8ab3591e0fcefa8c26ce3fd36d5a0f5a30620edd70e'
        ]);

        $this
        	->get(route('preferences.edit', [
        		'token' => 'eb4ac3033e8ab3591e0fcefa8c26ce3'
        	]))
        	->assertStatus(403);

    	$this
        	->get(route('preferences.edit', [
        		'token' => 'eb4ac3033e8ab3591e0fcefa8c26ce3fd36d5a0f5a30620edd70e'
        	]))
        	->assertStatus(200);
	} 

    /**
     * @test
     */
    public function testCreatedUserAndPlace()
    {
        $place = Place::create([
        	'name' => 'Giżycko',
        	'lat' => 54.03,
        	'lng' => 21.76
        ]);

        $user = User::create([
        	'email' => 'example@example.com',
        	'place_id' => 1
        ]);

        $this->post(route('preferences.store'))->assertStatus(302);
    }
}
