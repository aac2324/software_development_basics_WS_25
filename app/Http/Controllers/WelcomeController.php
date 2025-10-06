<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        // Fetch latest 2 events
        $events = \App\Models\Event::latest()->take(2)->get();

        return view('welcome', compact('events'));
    }
}
