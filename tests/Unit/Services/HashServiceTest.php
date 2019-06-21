<?php

namespace Tests\Unit\Services;

use App\Http\Services\HashService;
use Illuminate\Support\Collection;
use Tests\TestCase;

class HashServiceTest extends TestCase
{
    /**
     * @var HashService
     */
    private $hashService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->hashService = new HashService();
    }

    /**
     * Test if generateHash works.
     *
     * @dataProvider provideGenerateHash
     * @param string $expected
     * @param string $text
     * @return void
     */
    public function testGenerateHash(string $expected, string $text)
    {
        $this->assertEquals($expected, $this->hashService->generateHash($text));
    }

    /**
     * @return Collection
     */
    public function provideGenerateHash()
    {
        $texts = collect(["example1", "example2", "example3"]);

        return $texts->map(function ($text) {
            return [sha1($text).md5($text), $text];
        });
    }
}
