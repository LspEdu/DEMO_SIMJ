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
                'backgroundColor' => $event->type->color,
                'tipo' => $event->type->tipo,
                'tipoId' => $event->type->id,
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
        $event->type()->associate($request->input('tipo'));

        $event->save();

        return redirect()->route('home')->with('success','Evento creado con éxito');
    }

    public function update(Request $request)
    {

        $request->validate([
            'title' => 'required',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
        ]);

        $event = Event::findOrFail($request->id);
        $tipo = TypeEvent::findOrFail($request->tipo);
        $event->title = $request->input('title');
        $event->start = $request->input('start');
        $event->end = $request->input('end');
        $event->type()->associate($tipo);
        $event->save();

        return redirect()->route('home')->with('success','Evento editado con éxito');
    }

    public function destroy(Request $request)
    {
        $event = Event::findOrFail($request->id);
        $event->delete();

        return redirect()->route('home')->with('success','Evento eliminado con éxito');
    }


}
