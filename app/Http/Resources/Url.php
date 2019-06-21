<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Url extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'real_url' => $this->getRealUrl(),
            'short_url' => route('urls.view', ['short_url' => $this->getShortUrl()]),
            'view_counter' => $this->getViewsCount(),
        ];
    }
}
