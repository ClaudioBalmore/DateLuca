<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LinksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $links = Auth::user()->links()->get();

        return Inertia::render('Links/Index', [
            'links' => $links,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Links/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url',
        ]);

        Auth::user()->links()->create($request->only(['title', 'url']));

        return redirect()->route('links.index')->with('success', 'Link creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $link = Auth::user()->links()->findOrFail($id);

        return Inertia::render('Links/Show', [
            'link' => $link,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $link = Auth::user()->links()->findOrFail($id);

        return Inertia::render('Links/Edit', [
            'link' => $link,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $link = Auth::user()->links()->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url',
        ]);

        $link->update($request->only(['title', 'url']));

        return redirect()->route('links.index')->with('success', 'Link actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $link = Auth::user()->links()->findOrFail($id);

        $link->delete();

        return redirect()->route('links.index')->with('success', 'Link eliminado exitosamente.');
    }
}
