<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leave;
use Illuminate\Support\Facades\Auth;

class LeaveManagementController extends Controller
{
    public function index()
    {
        $pending_leaves = Leave::with('employee')
                            ->where('status', 'pending')
                            ->latest()
                            ->get();

        return view('leave.index', compact('pending_leaves'));
    }

    public function approve($id)
    {
        $leave = Leave::findOrFail($id);
        $leave->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now()
        ]);

        return redirect()->back()->with('success', 'Leave approved successfully.');
    }

    public function reject($id)
    {
        $leave = Leave::findOrFail($id);
        $leave->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
            'approved_at' => now()
        ]);

        return redirect()->back()->with('danger', 'Leave rejected.');
    }
}
