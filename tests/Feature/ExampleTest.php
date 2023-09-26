<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;


    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        Http::fake([
            // Stub a JSON response for GitHub endpoints...
            'github.com/*' => Http::response([
                ['name' => 'my-cool-repo-1'],
                ['name' => 'my-cool-repo-2'],
            ], 200),
        ]);

        Http::fake([
            'openweathermap.org/*' => Http::response([
                "weather" => [
                    ["description" => "broken clouds"],
                ],
                "main" => [
                    "temp" => 27.1,
                ],
            ], 200),
        ]);

        Http::fake([
            'themoviedb.org/*' => Http::response([
                'results' => [
                    ['title' => 'my-cool-movie-1'],
                    ['title' => 'my-cool-movie-2'],
                ],
            ],200),
        ]);

        $response = $this->get('/http-client');

        $response->assertSee('my-cool-repo-1');
        $response->assertSee('my-cool-repo-2');

        $response->assertSee('broken clouds');
        $response->assertSee('27.1');

        $response->assertSee('my-cool-movie-1');
        $response->assertSee('my-cool-movie-2');

        $response->assertStatus(200);
    }
}
