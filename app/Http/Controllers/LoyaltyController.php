<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Requests\PhoneRequest;
use App\Requests\CardRequest;

class LoyaltyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        dd($request->all(), 'test');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function card(Request $request)
    {
        dd('card');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd('create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $channel_id
     * @param  \Illuminate\Http\PhoneRequest  $phone
     * @return \Illuminate\Http\Response
     */
    public function show($channel_id, PhoneRequest $phone)
    {
        dd('show');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function verify($request)
    {
        dd('verify');
        if (FALSE === $this->validate($request->all(),
                ['mobile' => 'required|regex:/^1[34578]\d{9}$/|unique:users'], [
                    'mobile.required' => 'Пожалуйста, введите номер телефона',
                    'mobile.regex' => 'Неверный формат номера телефона',
                    'mobile.unique' => 'Номер мобильного телефона уже существует'
                ])) {
            return false;
        }

        $mobile = trim($request->get('mobile'));
        $code = str_pad(random_int(1, 9999), 4, 0, STR_PAD_LEFT);


        try {
            $easySms->send($mobile,
                ['content' => $code]);

        } catch (\GuzzleHttp\Exception\ClientException $exception) {
            $response = $exception->getResponse();
            $result = json_decode($response->getBody()->getContents(), true);
            $this->setMsg($result['msg'] ?? 'Отправка SMS ненормальная');
            return false;
        }

        $key = 'verificationCode' . str_random(15);
        $expiredAt = now()->addMinutes(1);
        Cache::put($key, ['mobile' => $mobile, 'code' => $code], $expiredAt);

        return [
            'verification_key' => $key,
            'expiredAt' => $expiredAt->toDateTimeString(),
            'verification_code' => $code
        ];
    }

    public function balance($request)
    {
        dd('balance');
    }

    public function compareCode($mobile, $verification_key, $code)
    {
        $verifyData = Cache::get($verification_key);
        if (!$verifyData) {
            $this->setMsg('Код подтверждения истек');
            return false;
        }

        if (!hash_equals($code, (string)$verifyData['code'])) {
            $this->setMsg('Ошибка кода подтверждения');
            return false;
        }

        Cache::forget($verification_key);

        $user = User::create([
            'mobile' => $mobile,
            'password' => bcrypt($password)
        ]);

        if (!$user) {
            $this->setMsg('Регистрация не удалась');
            return false;
        }

        return true;
    }
}
