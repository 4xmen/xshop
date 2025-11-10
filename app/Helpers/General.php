<?php

namespace App\Helpers;

class General
{
    static public function getSetting(string $key, int $ttl = 3600)
    {
        return getSetting($key, $ttl);
    }

}
