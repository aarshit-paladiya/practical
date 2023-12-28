<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function home()
    {
        if (Auth::user()->user_role == "super-admin") {
            return view('home.super-admin');

        } elseif (Auth::user()->user_role == "admin") {
            return view('home.admin');

        } else {
            return view('home.user');
        }
    }
}
