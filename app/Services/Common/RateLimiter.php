<?php

namespace App\Services\Common;

use Illuminate\Cache\RateLimiter as BaseRateLimiter;

class RateLimiter
{
    protected string $key;
    protected int $maxAttempts;
    protected int $decay;
    protected BaseRateLimiter $rateLimiter;

    public function __construct(string $key, int $maxAttempts = 5, int $decay = 60)
    {
        $this->key = $key;
        $this->maxAttempts = $maxAttempts;
        $this->decay = $decay;
        $this->rateLimiter = app(BaseRateLimiter::class);
    }

    public function tooManyAttempts(): bool
    {
        return $this->rateLimiter->tooManyAttempts($this->key, $this->maxAttempts);
    }

    public function hit(): int
    {
        return $this->rateLimiter->hit($this->key, $this->decay);
    }

    public function clear(): self
    {
        $this->rateLimiter->clear($this->key);

        return $this;
    }

    public function availableIn(): int
    {
        return $this->rateLimiter->availableIn($this->key);
    }

    //TODO дописать остальные методы
}
