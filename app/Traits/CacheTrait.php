<?php

namespace App\Traits;

use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

trait CacheTrait
{

    /**
     * cache or retrieve data if already exist
     * @param string $key
     * @param object|array|string $valueClosure
     * @param int $int,
     * @return object|array|string
     */
    public function cacheToRemember(string $key, object|array|string $valueClosure, int $ttl = null)
    {
        return Cache::remember($key, $ttl ??= now()->addHour(), $valueClosure);
    }
    

    /**
     * delete cache 
     * @param string $key
     * @return bool
     */
    public function forgetCache(string $key): bool
    {
        return Cache::forget($key);
    }

}
