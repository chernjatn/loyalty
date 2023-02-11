<?php
namespace App\Response;

/**
 * @method self setStatusCode(int $code, string $text = null)
 * @method self getStatusCode(): int
 */
interface Response
{
    public function setData(array $data = []);
    public function created(): self;
    public function fail(): self;
    public function success(): self;
    public function notFound(): self;
    public function forbidden(): self;
    public function unauthorized(): self;
    public function internalError(): self;
    public function tooManyReq(): self;
}
