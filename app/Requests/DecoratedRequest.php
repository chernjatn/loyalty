<?php

namespace App\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class DecoratedRequest extends FormRequest
{
    private FormRequest $child;

}
