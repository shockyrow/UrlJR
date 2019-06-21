<?php

namespace Tests\Feature;

use App\Http\Services\UrlService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UrlControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test if view redirects correctly
     *
     * @dataProvider provideViewRedirectsCorrectly
     * @param string $realUrl
     * @return void
     */
    public function testViewRedirectsCorrectly(string $realUrl)
    {
        $service = App(UrlService::class);
        $url = $service->generateShortUrl($realUrl);
        $response = $this->get(route('urls.view', [
            'shortUrl' => $url->getShortUrl(),
        ]));

        $response->assertRedirect(url($realUrl));
    }

    public function provideViewRedirectsCorrectly()
    {
        $faker = $this->makeFaker();

        return collect(range(1, 100))->map(
            function () use ($faker) {
                return [$faker->unique()->url];
            }
        );
    }
}
