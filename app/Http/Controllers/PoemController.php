<?php

namespace App\Http\Controllers;

use App\Models\Poem;
use App\Http\Requests\StorePoemRequest;
use App\Http\Requests\UpdatePoemRequest;
use Illuminate\Http\Request;

class PoemController extends Controller
{
    /**
     * Display a listing of the resource for the authenticated user.
     */
    public function index(Request $request)
    {
        $query = $request->user()->poems();

        // Search by title or author
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            });
        }

        // Filter by color
        if ($request->has('color') && !empty($request->color)) {
            $query->where('color', $request->color);
        }

        // Paginate results
        $perPage = $request->get('per_page', 10);
        $poems = $query->latest()->paginate($perPage);

        // Si es una petición API, devolver JSON
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json($poems);
        }

        // Si es una petición web de Inertia, devolver la vista
        return inertia('Poems/Index', [
            'poems' => $poems->items(),
            'pagination' => [
                'current_page' => $poems->currentPage(),
                'last_page' => $poems->lastPage(),
                'per_page' => $poems->perPage(),
                'total' => $poems->total(),
                'from' => $poems->firstItem(),
                'to' => $poems->lastItem(),
            ]
        ]);
    }

    /**
     * Get statistics for the dashboard.
     */
    public function stats()
    {
        $totalPoems = Poem::count();
        $uniqueAuthors = Poem::distinct('author')->count('author');
        $colors = Poem::select('color')
            ->selectRaw('count(*) as count')
            ->groupBy('color')
            ->get()
            ->map(fn($item) => ['color' => $item->color, 'count' => $item->count]);

        return response()->json([
            'total_poems' => $totalPoems,
            'unique_authors' => $uniqueAuthors,
            'colors' => $colors,
        ]);
    }

    /**
     * Get public poems for the React frontend.
     */
    public function publicPoems(Request $request)
    {
        $query = Poem::query();

        // Search by title or author
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            });
        }

        // Filter by color
        if ($request->has('color') && !empty($request->color)) {
            $query->where('color', $request->color);
        }

        // Get all poems (no pagination for React frontend)
        $poems = $query->latest()->get();

        return response()->json($poems);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Poems/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePoemRequest $request)
    {
        $poem = $request->user()->poems()->create($request->validated());

        // Si es una petición API, devolver JSON
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json($poem, 201);
        }

        // Si es una petición web de Inertia, redirigir
        return redirect()->route('poems.index')->with('success', 'Poema creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Poem $poem, Request $request)
    {
        if ($poem->user_id !== $request->user()->id) {
            abort(403);
        }

        // Si es una petición API, devolver JSON
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json($poem);
        }

        // Si es una petición web de Inertia, devolver la vista
        return inertia('Poems/Show', [
            'poem' => $poem
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Poem $poem, Request $request)
    {
        if ($poem->user_id !== $request->user()->id) {
            abort(403);
        }

        return inertia('Poems/Edit', [
            'poem' => $poem
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePoemRequest $request, Poem $poem)
    {
        if ($poem->user_id !== $request->user()->id) {
            abort(403);
        }

        $poem->update($request->validated());

        // Si es una petición API, devolver JSON
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json($poem);
        }

        // Si es una petición web de Inertia, redirigir
        return redirect()->route('poems.index')->with('success', 'Poema actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Poem $poem, Request $request)
    {
        if ($poem->user_id !== $request->user()->id) {
            abort(403);
        }

        $poem->delete();

        // Si es una petición API, devolver JSON
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json(null, 204);
        }

        // Si es una petición web de Inertia, redirigir
        return redirect()->route('poems.index')->with('success', 'Poema eliminado exitosamente.');
    }
}
