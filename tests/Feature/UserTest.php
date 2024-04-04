<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{

    /**
     * A basic feature test example.
     */
    public function test_app_is_healthy(): void
    {
        $response = $this->get(env("API_BASE_URL") .'/api/v1/health-check');

        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     */
    public function test_user_can_login_successfully(): void
    {
        
    }
}
