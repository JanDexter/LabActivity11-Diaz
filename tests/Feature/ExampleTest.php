<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * The home page just sends you to the bulletin.
     */
    public function test_home_redirects_to_posts(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/posts');
    }
}
