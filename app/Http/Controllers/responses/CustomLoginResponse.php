<?php

namespace App\Http\Responses;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class CustomLoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = Auth::user();

        if ($user && $user->role === 'admin') {
            $redirectUrl = route('admin.dashboard');
        } elseif ($user && $user->role === 'trainer') {
            $redirectUrl = route('trainer.dashboard');
        } else {
            $redirectUrl = route('trainee.dashboard');
        }

        return $request->wantsJson()
            ? response()->json(['redirect' => $redirectUrl])
            : redirect()->intended($redirectUrl);
    }
}