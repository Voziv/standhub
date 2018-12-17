<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function welcome()
    {
        if (\Auth::check()) {
            return redirect('home');
        }
        return view('welcome');
    }
}
