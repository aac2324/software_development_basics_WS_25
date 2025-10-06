<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        // Step 1: validate the incoming request data
        $request->validate([
            'event_id' => ['required', 'numeric'],
            'content' => ['required', 'string'],
            'rating' => ['required', 'integer', 'between:1,5'], // ✅ new
        ]);

        // Step 2: store the comment
        Review::create([
            'event_id' => $request->event_id,
            'user_id'  => auth()->id(),
            'content' => $request->content,
            'rating' => $request->rating, // ✅ new
        ]);

        session()->flash('specialMessage', 'Your review has been submitted!');

        return redirect()->route('events.show', $request->event_id);
    }


}
