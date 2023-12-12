<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\TypeEvent;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();

        $formattedEvents = [];
        foreach ($events as $event) {
            $formattedEvents[] = [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->start,
                'end' => $event->end,
            ];
        }

        return response()->json($formattedEvents);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
        ]);

        $event = new Event([
            'title' => $request->input('title'),
            'start' => $request->input('start'),
            'end' => $request->input('end'),
        ]);

        $event->save();

        return response()->json(['message' => 'Event created successfully']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
        ]);

        $event = Event::findOrFail($id);
        $event->title = $request->input('title');
        $event->start = $request->input('start');
        $event->end = $request->input('end');
        $event->save();

        return response()->json(['message' => 'Event updated successfully']);
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return response()->json(['message' => 'Event deleted successfully']);
    }

    public function typeIndex(Request $request){

        $perPage = $request->input('per_page', 10);
        $tipos = TypeEvent::paginate($perPage);
        return view('evento.tipo.index', compact('tipos'));

    }
}
