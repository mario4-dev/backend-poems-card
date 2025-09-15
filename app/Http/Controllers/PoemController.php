<?php

namespace App\Http\Controllers;

use App\Models\Poem;
use App\Http\Requests\StorePoemRequest;
use App\Http\Requests\UpdatePoemRequest;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class PoemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Poems/Index', [
            'poems' => Auth::user()->poems()->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Poems/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePoemRequest $request)
    {
        Auth::user()->poems()->create($request->validated());

        return redirect()->route('poems.index')->with('success', 'Poem created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Poem $poem): Response
    {
        if ($poem->user_id !== Auth::id()) {
            abort(403);
        }

        return Inertia::render('Poems/Edit', [
            'poem' => $poem,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePoemRequest $request, Poem $poem)
    {
        if ($poem->user_id !== Auth::id()) {
            abort(403);
        }

        $poem->update($request->validated());

        return redirect()->route('poems.index')->with('success', 'Poem updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Poem $poem)
    {
        if ($poem->user_id !== Auth::id()) {
            abort(403);
        }

        $poem->delete();

        return redirect()->route('poems.index')->with('success', 'Poem deleted successfully.');
    }
}
