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

        return response()->json($poems);
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Not necessary for an API
        return abort(404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePoemRequest $request)
    {
        $poem = $request->user()->poems()->create($request->validated());

        return response()->json($poem, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Poem $poem, Request $request)
    {
        if ($poem->user_id !== $request->user()->id) {
            abort(403);
        }

        return response()->json($poem);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Poem $poem)
    {
        // Not necessary for an API
        return abort(404);
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

        return response()->json($poem);
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

        return response()->json(null, 204);
    }
}
