<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Url\UrlRepository;
use App\Http\Resources\Url as UrlResource;
use App\Http\Services\HashService;
use App\Http\Services\UrlService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Validator;
use \Exception;

class UrlController extends Controller
{
    /**
     * @var UrlService
     */
    private $urlService;
    /**
     * @var HashService
     */
    private $hashService;
    /**
     * @var UrlRepository
     */
    private $urlRepository;

    /**
     * UrlController constructor.
     *
     * @param UrlService $urlService
     * @param HashService $hashService
     * @param UrlRepository $urlRepository
     */
    public function __construct(
        UrlService $urlService,
        HashService $hashService,
        UrlRepository $urlRepository
    ) {
        $this->urlService = $urlService;
        $this->hashService = $hashService;
        $this->urlRepository = $urlRepository;
    }

    /**
     * Get all urls
     *
     * @return AnonymousResourceCollection
     */
    public function getAll(): AnonymousResourceCollection
    {
        $urls = $this->urlRepository->getAll();

        return UrlResource::collection($urls);
    }

    /**
     * Get all own urls
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function getOwn(Request $request): AnonymousResourceCollection
    {
        $ownUrls = $request->session()->get('own_urls', collect([]));
        $urls = $this->urlRepository->getAllById($ownUrls->all());

        return UrlResource::collection($urls);
    }

    /**
     * Store new url
     *
     * @param Request $request
     * @return UrlResource|JsonResponse
     * @throws Exception
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'real_url' => 'required|url',
        ]);

        if($validator->fails()) {
            return new JsonResponse([
                'errors' => $validator->getMessageBag(),
            ]);
        }

        $realUrl = trim($request->input('real_url'));

        if ($this->urlRepository->hashExists($this->hashService->generateHash($realUrl))) {
            $url = $this->urlRepository->getByHash($this->hashService->generateHash($realUrl));
        } else {
            $url = $this->urlService->generateShortUrl($realUrl);
            $own_urls = $request->session()->get('own_urls', collect([]));
            $own_urls->push($url->getId());
            $request->session()->put(['own_urls' => $own_urls]);
        }

        return new UrlResource($url);
    }
}
