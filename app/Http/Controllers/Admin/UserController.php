<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Tampilkan halaman daftar pengguna dengan pencarian dan filter.
     */
    public function index(Request $request): View
    {
        $stats = [
            'total' => User::count(),
            'siswa' => User::where('role', 'siswa')->count(),
            'guru' => User::where('role', 'guru')->count(),
            'admin' => User::where('role', 'admin')->count(),
            'active' => User::where('status', 'active')->count(),
        ];

        $query = User::query()->latest();

        if (Schema::hasColumn('users', 'school_id')) {
            $query->with('school');
        }

        // Filter role jika ada
        if ($request->filled('role') && in_array($request->role, ['admin', 'guru', 'siswa'], true)) {
            $query->where('role', $request->role);
        }

        // Filter status jika ada
        if ($request->filled('status') && in_array($request->status, ['active', 'inactive', 'pending'], true)) {
            $query->where('status', $request->status);
        }

        // Search nama, email, no hp, atau nama sekolah
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('LOWER(username) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('LOWER(email) LIKE ?', ["%{$search}%"])
                  ->orWhere('phone_number', 'like', "%{$search}%");

                if (Schema::hasTable('schools') && Schema::hasColumn('users', 'school_id')) {
                    $q->orWhereHas('school', function ($sq) use ($search) {
                        $sq->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"]);
                    });
                }
            });
        }

        $users = $query->paginate(10)->withQueryString();

        return view('admin.users.index', compact('users', 'stats'));
    }

    /**
     * Tampilkan form pembuatan pengguna baru.
     */
    public function create(): View
    {
        $schools = Schema::hasTable('schools') ? School::orderBy('name')->get() : collect();
        return view('admin.users.create', compact('schools'));
    }

    /**
     * Simpan pengguna baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['nullable', 'string', 'max:50', 'alpha_dash', 'unique:users,username'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', Password::defaults()],
            'role' => ['required', 'in:admin,guru,siswa'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'school_name' => ['nullable', 'string', 'max:255'],
            'school_npsn' => ['nullable', 'string', 'max:50'],
            'status' => ['required', 'in:active,inactive,pending'],
        ]);

        $schoolId = null;
        if (!empty($validated['school_name']) && Schema::hasTable('schools')) {
            $school = School::findOrCreateByName($validated['school_name'], $request->input('school_npsn'));
            $schoolId = $school?->id;
        }

        $data = [
            'name' => $validated['name'],
            'username' => $validated['username'] ?? \Illuminate\Support\Str::slug(explode('@', $validated['email'])[0], '_'),
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'phone_number' => $validated['phone_number'],
            'status' => $validated['status'],
        ];

        if (Schema::hasColumn('users', 'school_id')) {
            $data['school_id'] = $schoolId;
        }

        $user = User::create($data);

        // Catat aktivitas
        if (Schema::hasTable('activity_logs')) {
            ActivityLog::record(
                'CREATE_USER',
                "Admin {$request->user()->name} menambahkan pengguna baru: {$user->name} ({$user->role}).",
                $request->user()
            );
        }

        return redirect()->route('admin.users.index')->with('success', "Pengguna {$user->name} berhasil ditambahkan!");
    }

    /**
     * Tampilkan form edit pengguna.
     */
    public function edit(User $user): View
    {
        $schools = Schema::hasTable('schools') ? School::orderBy('name')->get() : collect();
        return view('admin.users.edit', compact('user', 'schools'));
    }

    /**
     * Perbarui data pengguna di database.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['nullable', 'string', 'max:50', 'alpha_dash', 'unique:users,username,' . $user->id],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', Password::defaults()],
            'role' => ['required', 'in:admin,guru,siswa'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'school_name' => ['nullable', 'string', 'max:255'],
            'school_npsn' => ['nullable', 'string', 'max:50'],
            'status' => ['required', 'in:active,inactive,pending'],
        ]);

        // Proteksi akun sendiri
        if ($user->id === $request->user()->id) {
            if ($validated['role'] !== 'admin') {
                return back()->with('error', 'Anda tidak dapat mengubah role akun Anda sendiri.');
            }
            if ($validated['status'] !== 'active') {
                return back()->with('error', 'Anda tidak dapat menonaktifkan akun Anda sendiri.');
            }
        }

        $data = [
            'name' => $validated['name'],
            'username' => $validated['username'] ?? \Illuminate\Support\Str::slug(explode('@', $validated['email'])[0], '_'),
            'email' => $validated['email'],
            'role' => $validated['role'],
            'phone_number' => $validated['phone_number'],
            'status' => $validated['status'],
        ];

        if (Schema::hasColumn('users', 'school_id')) {
            if (!empty($validated['school_name']) && Schema::hasTable('schools')) {
                $school = School::findOrCreateByName($validated['school_name'], $request->input('school_npsn'));
                $data['school_id'] = $school?->id;
            } else {
                $data['school_id'] = null;
            }
        }

        // Jika password diisi, perbarui password
        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        // Catat aktivitas
        if (Schema::hasTable('activity_logs')) {
            ActivityLog::record(
                'UPDATE_USER',
                "Admin {$request->user()->name} memperbarui data pengguna {$user->name}.",
                $request->user()
            );
        }

        return redirect()->route('admin.users.index')->with('success', "Data pengguna {$user->name} berhasil diperbarui!");
    }

    /**
     * Hapus akun pengguna.
     */
    public function destroy(Request $request, User $user): RedirectResponse
    {
        // Cegah menghapus akun sendiri
        if ($user->id === $request->user()->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $userName = $user->name;
        $userRole = $user->role;

        $user->delete();

        // Catat aktivitas
        if (Schema::hasTable('activity_logs')) {
            ActivityLog::record(
                'DELETE_USER',
                "Admin {$request->user()->name} menghapus akun pengguna {$userName} (Role: {$userRole}).",
                $request->user()
            );
        }

        return redirect()->route('admin.users.index')->with('success', "Pengguna {$userName} berhasil dihapus.");
    }
}

