<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LinksController extends Controller
{
    private const LINK_URL_PATTERN = '/^(https?:\/\/)?(www\.)?([a-z0-9-]+\.)+[a-z]{2,}(:\d{2,5})?([\/?#][^\s]*)?$/i';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $links = $this->authUser()->links()->get();

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
        $request->validate($this->linkRules());

        $this->authUser()->links()->create($request->only(['title', 'url']));

        $redirectTo = $request->input('redirect_to');

        if (is_string($redirectTo) && str_starts_with($redirectTo, '/')) {
            return redirect($redirectTo)->with('success', 'Link creado exitosamente.');
        }

        return redirect()->route('links.index')->with('success', 'Link creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $link = $this->authUser()->links()->findOrFail($id);

        return Inertia::render('Links/Show', [
            'link' => $link,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $link = $this->authUser()->links()->findOrFail($id);

        return Inertia::render('Links/Edit', [
            'link' => $link,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $link = $this->authUser()->links()->findOrFail($id);

        $request->validate($this->linkRules());

        $link->update($request->only(['title', 'url']));

        $redirectTo = $request->input('redirect_to');

        if (is_string($redirectTo) && str_starts_with($redirectTo, '/')) {
            return redirect($redirectTo)->with('success', 'Link actualizado exitosamente.');
        }

        return redirect()->route('links.index')->with('success', 'Link actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $link = $this->authUser()->links()->findOrFail($id);

        $link->delete();

        $redirectTo = $request->input('redirect_to');

        if (is_string($redirectTo) && str_starts_with($redirectTo, '/')) {
            return redirect($redirectTo)->with('success', 'Link eliminado exitosamente.');
        }

        return redirect()->route('links.index')->with('success', 'Link eliminado exitosamente.');
    }

    private function authUser(): User
    {
        $user = Auth::user();

        if (! $user instanceof User) {
            abort(403);
        }

        return $user;
    }

    private function linkRules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'url' => ['required', 'string', 'max:2048', 'regex:'.self::LINK_URL_PATTERN],
            'redirect_to' => ['nullable', 'string', 'max:255'],
        ];
    }
}
