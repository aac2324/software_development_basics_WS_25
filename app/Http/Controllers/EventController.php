<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $articles = Event::all();

        return view('articles.index', compact('articles'));
    }

    public function show($id)
    {
        $article = Event::find($id);

        return view('articles.show', compact('article'));
    }

}
