<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_it_does_not_give_a_json_response_for_missing_pages()
    {
        $response = $this->get('/api/page_not_found');

        $response->assertNotFound();
        $this->assertStringIsNotJson($response->content());
    }

    public function assertStringIsNotJson(string $str): void
    {
        json_decode($str);
        $this->assertTrue(json_last_error() !== JSON_ERROR_NONE, 'Failed asserting that "'.$str.'" is not JSON.');
    }
}
