<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HostController extends Controller
{
    public function index()
    {
        // load the needed data
        $authors = \App\Models\User::all();

        // send to view + return response

        return view('hosts.index', compact('hosts'));
    }

    public function show($id)
    {
        $author = \App\Models\User::find($id);

        return view('hosts.show', compact('host'));
    }
}
