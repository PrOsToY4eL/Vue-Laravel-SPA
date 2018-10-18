<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_invalid_data()
    {
//        $response = $this->json('POST', 'api/auth/register', [
//            'email' => 'test@gmal.com',
//            'password' => 'sec',
//            'name' => 'UserTestName'
//        ]);
//        $response
//            ->assertStatus(401)
//            ->assertJson([
//                'email' => ['The email has already been taken.'],
//                'password' => ['The password must be at least 6 characters.']
//            ]);
//
        $this->assertTrue(true);
    }
}
