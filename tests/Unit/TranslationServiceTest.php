<?php

namespace Tests\Unit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Interfaces\TranslationServiceInterface;
use Tests\TestCase;

class TranslationServiceTest extends TestCase
{
    use RefreshDatabase;

    private TranslationServiceInterface $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(TranslationServiceInterface::class);
    }

    public function test_create_translation()
    {
        $translation = $this->service->createTranslation([
            'locale' => 'en',
            'key' => 'test_key',
            'value' => 'test_value',
        ]);

        $this->assertNotNull($translation);
        $this->assertEquals('test_key', $translation->key);
    }

    public function test_duplicate_translation()
    {
        $this->service->createTranslation([
            'locale' => 'en',
            'key' => 'test_key',
            'value' => 'test_value',
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('The combination of locale and key already exists.');

        $this->service->createTranslation([
            'locale' => 'en',
            'key' => 'test_key',
            'value' => 'test_value',
        ]);
    }
}
