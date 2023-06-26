<?php

namespace App\Services\Cache;

use Closure;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use App\Exceptions\Loyalty\ActionRepeatedException;

trait Throttles
{
    private static function throttle(string $method, string $key, Closure $closure, string $onExistsMessage, ?int $blockTtl = null): void
    {
        $methodKey = self::getThrottlePrefix() . ':' . $method . ':' . md5($key);
        $timeKey   = $methodKey . ':time';
        $ttl       = $blockTtl ?? self::getThrottleDefaultTtl();

        if (!RateLimiter::attempt($methodKey, 1, $closure, $ttl)) {
            throw new ActionRepeatedException($onExistsMessage, Carbon::createFromTimestamp(Cache::get($timeKey)));
        }

        Cache::add($timeKey, Carbon::now()->timestamp, $ttl * 2);
    }

    private static function getThrottleDefaultTtl(): int
    {
        return 900;
    }

    abstract private static function getThrottlePrefix(): string;
}
