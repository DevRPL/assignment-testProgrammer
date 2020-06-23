<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->get('/');

        $this->assertEquals(
            $this->app->version(), $this->response->getContent()
        );
    }

    public function testRegister()
    {
        $test = $this->post('/assignment2/register', [
            'name' => 'testing',
            'email' => 'user@test.com',
            'password' => 'secret',
            "address"   => "address",
            "phone"     => "022446677889",
            "role"      => "sellers"
        ]);

        $test->assertResponseStatus(201);
        $test->seeJsonStructure([
            "message",
            "code",
        ]);
    }
}
