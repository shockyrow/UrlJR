<?php

namespace App\Http\Repositories\Url;

use App\Url;
use Illuminate\Support\Collection;

class EloquentUrl implements UrlRepository
{
    /**
     * @var Url
     */
    private $model;

    public function __construct(Url $model)
    {
        $this->model = $model;
    }

    public function getAll(): Collection
    {
        return $this->model->all();
    }

    public function getAllById(array $ids): Collection
    {
        return $this->model->findOrFail($ids);
    }

    public function getByHash(string $hash): Url
    {
        return $this->model->where('hash', $hash)->firstOrFail();
    }

    public function getByShortUrl(string $shortUrl): Url
    {
        return $this->model->where('short_url', $shortUrl)->firstOrFail();
    }

    public function hashExists(string $hash): bool
    {
        return $this->model->where('hash', $hash)->exists();
    }

    public function create(array $attributes): Url
    {
        return $this->model->create($attributes);
    }

    public function update(int $id, array $attributes): Url
    {
        $url = $this->model->findOrFail($id);
        $url->update($attributes);

        return $url;
    }
}