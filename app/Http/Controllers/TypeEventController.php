<?php

namespace App\Http\Controllers;

use App\Models\TypeEvent;
use Illuminate\Http\Request;

class TypeEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $tipos = TypeEvent::paginate($perPage);
        return view('evento.tipo.index', compact('tipos'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'tipo'=> 'string | required | max:255',
            'color' => 'string | required | max:7 | min: 7',
        ]);

        $typeEvent = TypeEvent::create([
            'tipo' => $request->input('tipo'),
            'color' => $request->input('color'),
        ]);

        return redirect()->route('tipo.show')->with('success', 'Tipo de evento creado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TypeEvent  $typeEvent
     * @return \Illuminate\Http\Response
     */
    public function show(TypeEvent $typeEvent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TypeEvent  $typeEvent
     * @return \Illuminate\Http\Response
     */
    public function edit(TypeEvent $typeEvent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TypeEvent  $typeEvent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $typeEvent = TypeEvent::findOrFail($request->input('editarTipoId'));


        $this->validate(request(), [
            'tipo'=> 'string | required | max:255',
            'color' => 'string | required | max:7 | min: 7',
        ]);

        $typeEvent->update([
            "tipo" => $request->input("tipo"),
            "color"=> $request->input("color"),
        ]);

        return redirect()->route("tipo.show")->with("success","Tipo de Evento editado con éxito");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TypeEvent  $typeEvent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $typeEvent = TypeEvent::findOrFail($request->input('id'));
        $typeEvent->delete();
        return redirect()->route('tipo.show')->with('success','Tipo de Evento borrado con éxito');
    }
}
