<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\School;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $schools = Schema::hasTable('schools') ? School::orderBy('name')->get() : collect();

        return view('profile.edit', [
            'user' => $request->user()->loadMissing('school'),
            'schools' => $schools,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $user = $request->user();

        if (Schema::hasColumn('users', 'school_id')) {
            if (!empty($validated['school_name']) && Schema::hasTable('schools')) {
                $school = School::findOrCreateByName($validated['school_name'], $request->input('school_npsn'));
                $user->school_id = $school?->id;
            } else {
                $user->school_id = null;
            }
        }

        $user->fill([
            'name' => $validated['name'],
            'username' => $validated['username'] ?? $user->username,
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'] ?? null,
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        if (class_exists(\App\Models\ActivityLog::class) && \Illuminate\Support\Facades\Schema::hasTable('activity_logs')) {
            \App\Models\ActivityLog::record(
                'UPDATE_PROFILE',
                "Pengguna {$request->user()->name} memperbarui informasi profil akun.",
                $request->user()
            );
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Cegah admin tunggal menghapus akun sendiri
        if ($user->isAdmin() && \App\Models\User::where('role', 'admin')->count() <= 1) {
            return back()->with('error', 'Akun Administrator utama tidak dapat dihapus.');
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
