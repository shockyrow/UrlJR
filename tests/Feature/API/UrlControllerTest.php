<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class UrlControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test if store works
     *
     * @dataProvider provideStore
     * @param string $url
     * @return void
     */
    public function testStore(string $url)
    {
        $response = $this->post(route('api.urls.store'), [
            'real_url' => $url,
        ]);

        $response->assertJsonFragment([
            'real_url' => $url,
            'view_counter' => 0,
        ]);
    }

    public function provideStore()
    {
        $faker = $this->makeFaker();

        return collect(range(0, 100))->map(
            function () use ($faker) {
                return [$faker->unique()->url];
            }
        );
    }
}
