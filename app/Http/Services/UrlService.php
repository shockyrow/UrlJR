<?php

namespace App\Http\Services;

use App\Http\Repositories\Url\UrlRepository;
use App\Url;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UrlService
{
    /**
     * @var UrlRepository
     */
    private $urlRepository;
    /**
     * @var HashService
     */
    private $hashService;
    /**
     * @var string
     */
    private $shortUrlCharacters;
    /**
     * @var int
     */
    private $shortUrlLength;

    public function __construct(
        UrlRepository $urlRepository,
        HashService $hashService,
        string $shortUrlCharacters,
        string $shortUrlLength
    ) {
        $this->urlRepository = $urlRepository;
        $this->hashService = $hashService;
        $this->shortUrlCharacters = $shortUrlCharacters;
        $this->shortUrlLength = $shortUrlLength;
    }

    public function generateShortUrl(string $realUrl): Url
    {
        try {
            $url = $this->urlRepository->getByHash($this->hashService->generateHash($realUrl));
        } catch (ModelNotFoundException $modelNotFoundException) {
            $url = $this->urlRepository->create([
                'real_url' => $realUrl,
                'hash' => $this->hashService->generateHash($realUrl),
            ]);
        }

        $shortUrl = $url->getShortUrl();

        if ($shortUrl === null) {
            $shortUrl = '';
            $urlId = $url->getId();

            for ($i = 0; $i < $this->shortUrlLength; $i++) {
                $shortUrl = $this->shortUrlCharacters[$urlId % strlen($this->shortUrlCharacters)] . $shortUrl;
                $urlId = (int)($urlId / strlen($this->shortUrlCharacters));
            }

            $this->urlRepository->update($url->getId(), ['short_url' => $shortUrl]);
            $url->setShortUrl($shortUrl);
        }

        return $url;
    }
}