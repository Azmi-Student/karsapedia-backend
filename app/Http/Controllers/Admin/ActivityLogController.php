<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    /**
     * Tampilkan halaman riwayat lengkap log aktivitas sistem.
     */
    public function index(Request $request): View
    {
        $logs = collect();

        if (Schema::hasTable('activity_logs')) {
            $query = ActivityLog::with('user')->latest();

            // Filter aksi jika ada
            if ($request->filled('action')) {
                $query->where('action', $request->action);
            }

            // Filter search jika ada
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('description', 'like', "%{$search}%")
                      ->orWhereHas('user', function ($uq) use ($search) {
                          $uq->where('name', 'like', "%{$search}%")
                             ->orWhere('email', 'like', "%{$search}%");
                      });
                });
            }

            $logs = $query->paginate(15)->withQueryString();
        }

        return view('admin.activity-logs.index', compact('logs'));
    }
}

