<?php
namespace Tests\Feature;

use Tests\TestCase;

class TranslationControllerTest extends TestCase
{
    public function test_store_translation()
    {
        $response = $this->postJson('/api/translations', [
            'locale' => 'en',
            'key' => 'test_key',
            'value' => 'test_value',
        ]);

        $response->assertStatus(201)
                 ->assertJson(['key' => 'test_key']);
    }

    public function test_duplicate_translation()
    {
        $this->postJson('/api/translations', [
            'locale' => 'en',
            'key' => 'test_key',
            'value' => 'test_value',
        ]);

        $response = $this->postJson('/api/translations', [
            'locale' => 'en',
            'key' => 'test_key',
            'value' => 'test_value',
        ]);

        $response->assertStatus(422)
                 ->assertJson(['error' => 'The combination of locale and key already exists.']);
    }
}
