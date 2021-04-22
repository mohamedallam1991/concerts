<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Concert;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ConcertListingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function will_test_if_show_functions()
    {

        //arrange
        //create a aoncert
        // diret model accesss to create from testing what we want like a concert in this example without going to interfaces or doing soemthing manually
        $concert = Concert::create([
            'title' => 'The Red Chord',
            'subtitle' => 'yeah',
            'date' => Carbon::parse('December 13, 2016, 8:00pm'),
            'ticket_price' => 3250,
            'venue' => 'The Mosh Pit',
            'venue_address' => '123 Example Lane',
            'city' => 'Laraville',
            'state' => 'ON',
            'zip' => '17916',
            'additional_information' => 'For tickets, call (555) 555-5555',
        ]);

        $concertDatabase = Concert::first();

        // assertion database has one concert only
        $this->assertEquals($concertDatabase->toArray(), $concert->toArray());
        $this->assertDatabaseCount('concerts', 1);
        /* we created a listing in the database
        we are showing our static listing in the database
        optional:
        we can assert database has the listing */

        //act
        // try to view the concert listing
        $response = $this->get('/concerts/'.$concert);

        //$response = $this->get('/test');
        //$response->assertStatus(200);
        //$response->assertStatus(500);
        //asert
        // ability to see the concert details
        // adam has 9 assertions
        $response->assertSee('The Red Chord');
        $response->assertSee('32.50');
        $response->assertSee('December 13, 2016');
        $response->assertSee('8:00pm');
        $response->assertSee('The Mosh Pit');
        $response->assertSee('123 Example Lane');
        $response->assertSee('Laraville, On 17916');
        $response->assertSee('For tickets, call (555) 555-5555');


        $response->assertSeeText('32.50');
        $response->assertSeeText('32.50');
        $response->assertSeeText('December 13, 2016');
        $response->assertSeeText('8:00pm');
        $response->assertSeeText('The Mosh Pit');
        $response->assertSeeText('123 Example Lane');
        $response->assertSeeText('Laraville, On 17916');
        $response->assertSeeText('For tickets, call (555) 555-5555');


    }
}
