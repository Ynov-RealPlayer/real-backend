<?php

namespace Tests\Unit;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_that_true_is_true()
    {
        $this->assertTrue(true);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_get_admin_route()
    {
        $response = $this->get('/admin/login');
        // check if the response is a 200
        $response->assertStatus(200);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_can_register()
    {
        $data = [
            'pseudo' => 'ddddddddddd',
            'email' => 'regiss3@test.fr',
            'password' => 'passworddd',
            'confirm_password' => 'passworddd',
        ];
        $response = $this->post('/api/register', $data);
        $response->assertStatus(200);
    }
}
