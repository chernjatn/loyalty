<?php
namespace App\Response;

use Illuminate\Http\JsonResponse;

class ApiResponse extends JsonResponse implements Response
{
    public function created(): self
    {
        $this->setStatusCode(self::HTTP_CREATED);
        return $this;
    }

    public function success(): self
    {
        $this->setStatusCode(self::HTTP_OK);
        return $this;
    }

    public function fail(): self
    {
        $this->setStatusCode(self::HTTP_INTERNAL_SERVER_ERROR);
        return $this;
    }

    public function notFound(): self
    {
        $this->setStatusCode(self::HTTP_NOT_FOUND);
        return $this;
    }

    public function forbidden(): self
    {
        $this->setStatusCode(self::HTTP_FORBIDDEN);
        return $this;
    }

    public function unauthorized(): self
    {
        $this->setStatusCode(self::HTTP_UNAUTHORIZED);
        return $this;
    }

    public function internalError(): self
    {
        $this->setStatusCode(self::HTTP_INTERNAL_SERVER_ERROR);
        return $this;
    }

    public function tooManyReq(): self
    {
        $this->setStatusCode(self::HTTP_TOO_MANY_REQUESTS);
        return $this;
    }

}
