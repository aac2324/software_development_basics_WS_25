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
            'rating' => ['required', 'integer', 'between:1,5'], 
        ]);


        // Step 2: check if the user already reviewed this event
        $existingReview = \App\Models\Review::where('user_id', auth()->id())
            ->where('event_id', $request->event_id)
            ->first();

        if ($existingReview) {
            // Prevent duplicate review submission
            return redirect()
                ->route('events.show', $request->event_id)
                ->with('specialMessage', 'You already reviewed this event!');
        }
            
        //store the comment
        Review::create([
            'event_id' => $request->event_id,
            'user_id'  => auth()->id(),
            'content' => $request->content,
            'rating' => $request->rating, 
        ]);

        session()->flash('specialMessage', 'Your review has been submitted!');

        return redirect()->route('events.show', $request->event_id);
    }


}
