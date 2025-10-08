<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HostController extends Controller
{
    public function index()
    {
        // load the needed data
        $hosts = \App\Models\User::query()
        ->where('role', 'host')        // only hosts
        ->whereHas('events')      // only hosts with events
        ->with('events')               // eager load events for the view
        ->withAvg('hostedReviews', 'rating') // => hosted_reviews_avg_rating
        ->get();

        // send to view + return response

        return view('hosts.index', compact('hosts'));
    }

    public function show($id)
    {
        $host = \App\Models\User::with(['events'])
            ->withAvg('hostedReviews', 'rating')
            ->findOrFail($id);
            
        return view('hosts.show', compact('host'));
    }
}
