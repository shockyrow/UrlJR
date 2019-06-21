<?php

namespace App\Http\Services;

class HashService
{
    public function generateHash(string $text): string
    {
        return sha1($text) . md5($text);
    }
}