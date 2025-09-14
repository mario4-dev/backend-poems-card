<?php

namespace App\Http\Controllers;

use App\Models\Poem;
use Illuminate\Http\Request;

class PoemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $poems = Poem::all();
        return response()->json($poems);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // No necesario para API
        return abort(404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'author' => 'required|string|max:255',
            'color' => 'required|string|max:50',
        ]);

        $poem = Poem::create($validated);
        return response()->json($poem, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Poem $poem)
    {
        return response()->json($poem);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Poem $poem)
    {
        // No necesario para API
        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Poem $poem)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
            'author' => 'sometimes|required|string|max:255',
            'color' => 'sometimes|required|string|max:50',
        ]);

        $poem->update($validated);
        return response()->json($poem);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Poem $poem)
    {
        $poem->delete();
        return response()->json(null, 204);
    }
}
