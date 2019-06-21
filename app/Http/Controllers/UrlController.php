<?php

namespace App\Http\Controllers;

use App\Http\Repositories\Url\UrlRepository;
use App\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class UrlController extends Controller
{
    /**
     * @var UrlRepository
     */
    private $urlRepository;

    /**
     * UrlController constructor.
     * @param UrlRepository $urlRepository
     */
    public function __construct(UrlRepository $urlRepository)
    {
        $this->urlRepository = $urlRepository;
    }

    public function view(Request $request, string $shortUrl)
    {
        Session::save();

        $url = $this->urlRepository->getByShortUrl($shortUrl);

        try {
            View::create([
                'url_id' => $url->getId(),
                'session_id' => $request->session()->getId(),
            ]);
        } catch (QueryException $queryException) {
            Log::debug($queryException->getMessage());
        }

        return Redirect::to($url->getRealUrl());
    }
}
