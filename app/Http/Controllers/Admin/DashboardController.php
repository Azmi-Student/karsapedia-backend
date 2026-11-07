<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman utama monitoring admin.
     */
    public function index(Request $request): View
    {
        $totalUsers = User::count();
        $totalSiswa = User::where('role', 'siswa')->count();
        $totalGuru = User::where('role', 'guru')->count();
        $totalAdmin = User::where('role', 'admin')->count();
        $activeUsers = User::where('status', 'active')->count();
        $inactiveUsers = $totalUsers - $activeUsers;

        $stats = [
            'total_users' => $totalUsers,
            'total_siswa' => $totalSiswa,
            'total_guru' => $totalGuru,
            'total_admin' => $totalAdmin,
            'active_users' => $activeUsers,
            'inactive_users' => $inactiveUsers,
            'active_rate' => $totalUsers > 0 ? round(($activeUsers / $totalUsers) * 100) : 100,
            'siswa_rate' => $totalUsers > 0 ? round(($totalSiswa / $totalUsers) * 100) : 0,
            'guru_rate' => $totalUsers > 0 ? round(($totalGuru / $totalUsers) * 100) : 0,
            'admin_rate' => $totalUsers > 0 ? round(($totalAdmin / $totalUsers) * 100) : 0,
        ];

        // 7 Hari Terakhir untuk visual chart
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $count = User::whereDate('created_at', $date->toDateString())->count();
            $chartData[] = [
                'day' => $date->format('D'),
                'date' => $date->format('d M'),
                'count' => $count,
                'is_today' => $i === 0,
                // Skala tinggi bar persentase (min 20%, max 95%)
                'height' => $count > 0 ? min(95, 30 + ($count * 20)) : 22,
            ];
        }

        // Ambil Log Aktivitas Terkini
        $recentLogs = collect();
        if (Schema::hasTable('activity_logs')) {
            $recentLogs = ActivityLog::with('user')->latest()->take(5)->get();
        }

        $latestUsers = User::latest()->take(3)->get();

        return view('admin.dashboard', compact('stats', 'chartData', 'recentLogs', 'latestUsers'));
    }

    /**
     * Update status aktif/non-aktif akun pengguna.
     */
    public function updateStatus(Request $request, User $user): RedirectResponse
    {
        // Cegah admin menonaktifkan akunnya sendiri
        if ($user->id === $request->user()->id) {
            return back()->with('error', 'Anda tidak dapat mengubah status akun Anda sendiri.');
        }

        $validated = $request->validate([
            'status' => ['required', 'in:active,inactive,pending'],
        ]);

        $user->update(['status' => $validated['status']]);

        // Catat ke activity logs
        if (Schema::hasTable('activity_logs')) {
            ActivityLog::record(
                'UPDATE_STATUS',
                "Admin {$request->user()->name} mengubah status akun {$user->name} menjadi {$validated['status']}.",
                $request->user()
            );
        }

        return back()->with('success', "Status akun {$user->name} berhasil diubah menjadi {$validated['status']}.");
    }

    /**
     * Update role pengguna.
     */
    public function updateRole(Request $request, User $user): RedirectResponse
    {
        // Cegah admin mengubah role akunnya sendiri
        if ($user->id === $request->user()->id) {
            return back()->with('error', 'Anda tidak dapat mengubah role akun Anda sendiri.');
        }

        $validated = $request->validate([
            'role' => ['required', 'in:admin,guru,siswa'],
        ]);

        $oldRole = $user->role;
        $user->update(['role' => $validated['role']]);

        // Catat ke activity logs
        if (Schema::hasTable('activity_logs')) {
            ActivityLog::record(
                'UPDATE_ROLE',
                "Admin {$request->user()->name} mengubah role {$user->name} dari {$oldRole} menjadi {$validated['role']}.",
                $request->user()
            );
        }

        return back()->with('success', "Role {$user->name} berhasil diubah menjadi {$validated['role']}.");
    }
}

