<?php

namespace App\Http\Repositories\Url;

use App\Url;
use Illuminate\Support\Collection;

interface UrlRepository
{
    public function getAll(): Collection;

    public function getAllById(array $ids): Collection;

    public function getByHash(string $hash): Url;

    public function getByShortUrl(string $shortUrl): Url;

    public function hashExists(string $hash): bool;

    public function create(array $attributes): Url;

    public function update(int $id, array $attributes): Url;
}