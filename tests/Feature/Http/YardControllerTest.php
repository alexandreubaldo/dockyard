<?php

namespace Tests\Feature\Http;

use App\Models\Yard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\CreatesApplication;
use Tests\TestCase;

class YardControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Tests if the list of yards endpoint is working
     *
     * @return void
     */
    public function test_yards_are_listed()
    {
        $items = rand(1, 15);
        
        Yard::factory()
            ->count($items)
            ->create();
        
        $response = $this->getJson('api/yards');
        $response
            ->assertStatus(200)
            ->assertJsonCount($items, 'data');
    }

    public function test_specific_yard_is_displayed()
    {
        $yard = Yard::factory()->create();
        $response = $this->getJson("api/yards/{$yard->id}");
        $response
            ->assertStatus(200)
            ->assertJsonFragment(['locator' => $yard->locator]);
    }

    public function test_yard_can_be_created()
    {
        $yard = Yard::factory()->make();        
        $response = $this->postJson("api/yards", $yard->toArray());
        $response
            ->assertStatus(201)
            ->assertJsonFragment(['locator' => $yard->locator]);
    }


    public function test_yard_can_be_updated()
    {
        
        $yard = Yard::factory()->create();
        $new_attributes = [
            'locator' => $yard->locator,
            'width' => $yard->width/2,
            'length' => $yard->length/2
        ];
        $response = $this->putJson("api/yards/{$yard->id}", $new_attributes);
        $response
            ->assertStatus(200)
            ->assertJsonFragment(['width'=>$new_attributes['width']]);
    }


    public function test_yard_can_be_deleted()
    {
        $yard = Yard::factory()->create();
        $response = $this->deleteJson("api/yards/{$yard->id}");
        $response->assertStatus(200);
        $this->assertDatabaseMissing('yards', [
            'locator' => $yard->locator
        ]);
    }
}