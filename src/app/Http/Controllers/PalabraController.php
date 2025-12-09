<?php

namespace App\Http\Controllers;

use App\Models\Palabra;
use Illuminate\Http\Request;

class PalabraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $palabras = Palabra::all(); // <-- Usa Eloquent
        return view('palabras.index', ['palabras' => $palabras]);
    }

    public function indexStyled()
    {
        $palabras = Palabra::all(); // <-- Usa Eloquent
        return view('palabras.index_styled', ['palabras' => $palabras]);
    }

    public function indexBlade()
    {
        $palabras = Palabra::all(); // <-- Usa Eloquent
        return view('palabras.index_blade', ['palabras' => $palabras]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Palabra $palabra)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Palabra $palabra)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Palabra $palabra)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Palabra $palabra)
    {
        //
    }
}
