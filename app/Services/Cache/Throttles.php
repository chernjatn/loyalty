<?php

namespace App\Services\Cache;

use Closure;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use App\Services\Cache\Exceptions\ActionRepeatedException;

trait Throttles
{
    private static function throttle(string $method, string $key, Closure $closure, string $onExistsMessage, ?int $blockTtl = null): void
    {
        $methodKey = $method . ':' . $key;
        $timeKey   = $methodKey . ':time';
        $ttl       = $blockTtl ?? self::getThrottleDefaultTtl();

        if (!RateLimiter::attempt($methodKey, 1, $closure, $ttl)) {
            throw new ActionRepeatedException($onExistsMessage, Carbon::createFromTimestamp(Cache::store('redis')->get($timeKey)));
        }

        Cache::store('redis')->add($timeKey, Carbon::now()->addSeconds($ttl)->timestamp, $ttl);
    }

    private static function getThrottleDefaultTtl(): int
    {
        return 900;
    }
}
