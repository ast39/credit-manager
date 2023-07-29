<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class DemoController extends Controller {

    public function __invoke(): RedirectResponse
    {
        Auth::login(User::find(1));

        return redirect(RouteServiceProvider::HOME);
    }
}
