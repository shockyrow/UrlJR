<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class View
 *
 * @package App
 * @property int $id
 * @property int $url_id
 * @property string $session_id
 */
class View extends Model
{
    protected $fillable = [
        'url_id',
        'session_id',
    ];

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getUrlId(): int
    {
        return $this->url_id;
    }

    /**
     * @param int $url_id
     * @return View
     */
    public function setUrlId(int $url_id): View
    {
        $this->url_id = $url_id;

        return $this;
    }

    /**
     * @return string
     */
    public function getSessionId(): string
    {
        return $this->session_id;
    }

    /**
     * @param string $session_id
     * @return View
     */
    public function setSessionId(string $session_id): View
    {
        $this->session_id = $session_id;

        return $this;
    }
}
