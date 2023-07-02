<?php

namespace App\Exceptions\Loyalty;

use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class CustomValidationException extends BadRequestException
{
    protected array $data = [
        'errors' => [],
    ];

    public static function fromValidationException(ValidationException $exc): self
    {
        $message = $exc->validator->errors()->first();

        return (new self($message, Response::HTTP_UNPROCESSABLE_ENTITY, $exc))
            ->setData([
                'message' => $message,
                'errors'  => $exc->errors(),
            ]);
    }
}
