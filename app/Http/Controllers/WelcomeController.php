<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $events = \App\Models\Event::latest()->take(5)->get();
        $hosts = \App\Models\User::where('role', 'host')->take(5)->get();

        return view('welcome', compact('events', 'hosts'));
    }


}
