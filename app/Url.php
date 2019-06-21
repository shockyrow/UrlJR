<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Url
 *
 * @package App
 * @property int $id
 * @property string $hash
 * @property string $real_url
 * @property string|null $short_url
 */
class Url extends Model
{
    protected $fillable = [
        'hash',
        'real_url',
        'short_url',
    ];

    public function getViewsCount(): int
    {
        return $this->views()->count();
    }

    public function views(): HasMany
    {
        return $this->hasMany(View::class);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }

    /**
     * @param string $hash
     * @return Url
     */
    public function setHash(string $hash): Url
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * @return string
     */
    public function getRealUrl(): string
    {
        return $this->real_url;
    }

    /**
     * @param string $real_url
     * @return Url
     */
    public function setRealUrl(string $real_url): Url
    {
        $this->real_url = $real_url;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getShortUrl(): ?string
    {
        return $this->short_url;
    }

    /**
     * @param string|null $short_url
     * @return Url
     */
    public function setShortUrl(?string $short_url): Url
    {
        $this->short_url = $short_url;

        return $this;
    }
}
