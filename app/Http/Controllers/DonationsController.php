<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePublicDonationRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DonationsController extends Controller
{
    private const CLP_PER_LUCA = 1000;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = $this->authUser();

        return Inertia::render('Donations/Index', [
            'donations' => $user->donations()->orderBy('donation_date', 'desc')->get(),
        ]);
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
        $user = $this->authUser();

        $request->validate([
            'donor_name' => 'required|string|max:255',
            'message' => 'nullable|string|max:100',
            'donation_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
        ]);

        $user->donations()->create($request->only([
            'donor_name',
            'message',
            'donation_date',
            'amount',
        ]));

        return redirect()->route('donations.index');
    }

    /**
     * Store a donation from a public profile page.
     */
    public function storeFromPublicProfile(StorePublicDonationRequest $request, string $slug): RedirectResponse
    {
        $profileOwner = User::where('slug', $slug)->firstOrFail();

        if ($request->user()?->id === $profileOwner->id) {
            return back()->withErrors([
                'lucas' => 'No puedes donarte a ti mismo desde tu perfil.',
            ]);
        }

        $lucas = (int) $request->integer('lucas');
        $donorName = $request->user()?->name ?? trim((string) $request->input('donor_name'));
        $message = trim((string) $request->input('message'));

        $profileOwner->donations()->create([
            'donor_name' => $donorName,
            'message' => $message === '' ? null : $message,
            'donation_date' => now()->toDateString(),
            'amount' => $lucas * self::CLP_PER_LUCA,
        ]);

        return redirect()
            ->route('dashboard.slug', ['slug' => $profileOwner->slug])
            ->with('status', 'donation-success');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function authUser(): User
    {
        $user = Auth::user();

        if (! $user instanceof User) {
            abort(403);
        }

        return $user;
    }
}
