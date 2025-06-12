<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\NotificationSetting;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function blockUser(User $user)
    {
        $user->is_active = false;
        $user->save();

        ActivityLog::safeCreate([
            'user_id' => auth()->id(),
            'action' => "blocked user {$user->id}",
            'ip_address' => request()->ip(),
        ]);

        return back();
    }

    public function destroyUser(User $user)
    {
        $user->delete();

        ActivityLog::safeCreate([
            'user_id' => auth()->id(),
            'action' => "deleted user {$user->id}",
            'ip_address' => request()->ip(),
        ]);

        return back();
    }

    public function roles()
    {
        $roles = Role::all();
        $users = User::all();
        return view('admin.roles', compact('roles', 'users'));
    }

    public function updateUserRole(Request $request, User $user)
    {
        $request->validate(['roleID' => 'required|exists:roles,id']);
        $user->roleID = $request->roleID;
        $user->save();

        ActivityLog::safeCreate([
            'user_id' => auth()->id(),
            'action' => "updated role for user {$user->id}",
            'ip_address' => $request->ip(),
        ]);

        return back();
    }

    public function schedules()
    {
        return view('admin.schedules');
    }

    public function notifications()
    {
        $settings = NotificationSetting::all();
        return view('admin.notifications', compact('settings'));
    }

    public function updateNotifications(Request $request)
    {
        foreach ($request->settings as $key => $value) {
            NotificationSetting::updateOrCreate(['setting_key' => $key], ['setting_value' => $value]);
        }

        ActivityLog::safeCreate([
            'user_id' => auth()->id(),
            'action' => 'updated notification settings',
            'ip_address' => $request->ip(),
        ]);

        return back();
    }

    public function reports()
    {
        return view('admin.reports');
    }
}
