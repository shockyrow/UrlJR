<?php

namespace Tests\Unit\Services;

use App\Http\Repositories\Url\UrlRepository;
use App\Http\Services\HashService;
use App\Http\Services\UrlService;
use App\Url;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class UrlServiceTest extends TestCase
{
    const EXAMPLE_SHORT_URL_CHARACTERS = "abcd";
    const EXAMPLE_SHORT_URL_LENGTH = 3;
    const EXAMPLE_HASH = "example-hash";
    const EXAMPLE_URL = "example-url";
    const EXAMPLE_URL_ID = 1;

    /**
     * @var UrlService
     */
    private $urlService;
    /**
     * @var MockObject|UrlRepository
     */
    private $mockUrlRepository;
    /**
     * @var MockObject|HashService
     */
    private $mockHashService;
    /**
     * @var Url
     */
    private $url;

    protected function setUp(): void
    {
        parent::setUp();

        $this->url = new Url([
            'real_url' => self::EXAMPLE_URL,
        ]);
        $this->url->id = self::EXAMPLE_URL_ID;

        $this->mockUrlRepository = $this->createMock(UrlRepository::class);
        $this
            ->mockUrlRepository
            ->method('getByHash')
            ->with(self::EXAMPLE_HASH)
            ->willReturn($this->url)
        ;

        $this->mockHashService = $this->createMock(HashService::class);
        $this
            ->mockHashService
            ->method('generateHash')
            ->with(self::EXAMPLE_URL)
            ->willReturn(self::EXAMPLE_HASH)
        ;

        $this->urlService = new UrlService(
            $this->mockUrlRepository,
            $this->mockHashService,
            self::EXAMPLE_SHORT_URL_CHARACTERS,
            self::EXAMPLE_SHORT_URL_LENGTH
        );
    }

    /**
     * Test if generateShortUrl works.
     *
     * @return void
     */
    public function testGenerateShortUrl()
    {
        $this->assertEquals($this->url, $this->urlService->generateShortUrl(self::EXAMPLE_URL));
    }
}
