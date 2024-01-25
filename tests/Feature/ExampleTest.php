<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
