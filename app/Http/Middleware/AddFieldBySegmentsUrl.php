<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;
use App\Entity\Phone;
use App\Services\Sms\NotificationService;


class AddFieldBySegmentsUrl
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->route('clientTel')) {
            $key = NotificationService::keyGenerate(Phone::parse($request->route('clientTel')));
            $code = Redis::connection()->get($key);

            $request = $request->merge(['phone' => $request->route('clientTel')]);

            if (!is_null($code)) {
                $request = $request->merge(['sentCode' => $code]);
            }
        }

        if ($request->route('cardId')) {
            $request->merge(['card' => $request->route('cardId')]);
        }

        return $next($request);
    }
}
