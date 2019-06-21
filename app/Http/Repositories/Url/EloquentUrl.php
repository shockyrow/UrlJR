<?php

namespace App\Http\Repositories\Url;

use App\Url;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class EloquentUrl implements UrlRepository
{
    /**
     * @var Url
     */
    private $model;

    /**
     * EloquentUrl constructor.
     *
     * @param Url $model
     */
    public function __construct(Url $model)
    {
        $this->model = $model;
    }

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->model->all();
    }

    /**
     * @param array $ids
     * @return Collection
     * @throws ModelNotFoundException
     */
    public function getAllById(array $ids): Collection
    {
        return $this->model->findOrFail($ids);
    }

    /**
     * @param string $hash
     * @return Url
     * @throws ModelNotFoundException
     */
    public function getByHash(string $hash): Url
    {
        return $this->model->where('hash', $hash)->firstOrFail();
    }

    /**
     * @param string $shortUrl
     * @return Url
     * @throws ModelNotFoundException
     */
    public function getByShortUrl(string $shortUrl): Url
    {
        return $this->model->where('short_url', $shortUrl)->firstOrFail();
    }

    /**
     * @param string $hash
     * @return bool
     */
    public function hashExists(string $hash): bool
    {
        return $this->model->where('hash', $hash)->exists();
    }

    /**
     * @param array $attributes
     * @return Url
     */
    public function create(array $attributes): Url
    {
        return $this->model->create($attributes);
    }

    /**
     * @param int $id
     * @param array $attributes
     * @return Url
     * @throws ModelNotFoundException
     */
    public function update(int $id, array $attributes): Url
    {
        $url = $this->model->findOrFail($id);
        $url->update($attributes);

        return $url;
    }
}