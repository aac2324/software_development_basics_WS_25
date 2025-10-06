<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventManagementController extends Controller
{
    public function index()
    {
        // fetch events from DB that I am allowed to edit
        $events = \App\Models\Event::where('host_id', auth()->user()->id)->get();

        //dd($events); // to quickly analyse what you loaded

        // send events to the view
        // return response
        return view('management.events.index', compact('events'));

    }

    public function show($id)
    {
        // fetch the one event that is requested
        $event = \App\Models\Event::find($id);

        // send article to its view
        // return response
        return view('management.events.show', compact('event'));
    }

    public function create()
    {
        return view('management.events.create');
    }

    public function store(Request $request)
    {
        // Step 1: validate the incoming request data
        $request->validate([
            'title' => ['required', 'string', 'max:25', 'min:3'],
            'content' => ['required', 'string'],
        ]);

        $event = Event::create([
            'title' => $request->title,
            'content' => $request->content,
            'host_id' => auth()->user()->id,
        ]);

        return redirect()->route('events.show', $event->id);
    }

    public function edit($id)
    {
        // Get the event
        $event = \App\Models\Event::find($id);

        // Check access rights
        if (! $event->canEditOrDelete( auth()->user() )) {
            return redirect()->route('events.show', ['id' => $event->id]);
        }

        return view('management.events.edit', compact('event'));
    }

    public function update(Request $request, $id)
    {
        // Step 1: load the correct article from MODEL
        $event = \App\Models\Event::find($id);

        // Check access rights
        if (! $event->canEditOrDelete( auth()->user() )) {
            abort(403);
        }

        // Step 2: validate the incoming request data
        $request->validate([
            'title' => ['required', 'string', 'max:25', 'min:10'],
            'content' => ['required', 'string'],
        ]);

        // Step 3: Update the changes
        $event->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        session()->flash('specialMessage', 'Your update of the article was successful');

        // Redirect to show
        return redirect()->route('events.show', $event->id);
    }

    public function destroy($id)
    {
        // fetch the one article that is requested
        $event = \App\Models\Event::find($id);

        // Check access rights
        if (! $event->canEditOrDelete( auth()->user() )) {
            abort(403);
        }

        $event->delete();

        return redirect()->route('events.index');
    }

}
