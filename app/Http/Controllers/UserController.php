<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
    public function authUser(Request $request) {
        $fillable = $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:3|max:255',
        ]);

        // Пытаемся залогиниться
        if (Auth::attempt($fillable, $request->remember)) {
            $user = Auth::user();

            if ($user->is_active == 0) {
                return redirect()->route('passChange');
            } else {
                return redirect()->route('home');
            }
        } else {

            return back()->withErrors([
                'failAuth' => 'Ошибка в почте или пароле.'
            ])->withInput();
        }
    }

    public function logout() {
        Auth::logout();
        return redirect() -> route('home');
    }

    public function userPassChange (Request $request) {
        $fillable = $request -> validate ([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            return back() -> withErrors([
                'failAuth' => 'Неверный старый пароль.'
            ]);
        }

        $user->password = Hash::make($request->new_password);
        $user->is_active = 1;
        $user->save();

        return redirect() -> route('home');
    }

    public function createUserAccount (Request $request) {
        $fillable = $request -> validate([
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|max:255',
            'password' => 'required|min:3|max:255',
            'roleID' => 'required',
        ]);

        User::create($fillable);
        return response()->json(['message' => 'Пользователь успешно добавлен']);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Если хочешь — можно сделать валидацию:
        $validated = $request->validate([
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'birth_date' => 'nullable|date',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
        ]);
        $user->first_name = $validated['first_name'];
        $user->middle_name = $validated['middle_name'];
        $user->last_name = $validated['last_name'];
        $user->email = $validated['email'];
        $user->birth_date = $validated['birth_date'];
        $user->phone = $request->phone ?? '';
        $user->address = $request->address ?? '';

        $user->save();

        return response()->json([
            'message' => 'Профиль успешно обновлён!',
            'updated' => [
                'first_name' => $user->first_name,
                'middle_name' => $user->middle_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'birth_date' => $user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->format('Y-m-d') : null,
                'phone' => $user->phone,
                'address' => $user->address,
            ]
        ]);

    }

    public function userUpdate(Request $request)
    {
        $roles = Role::all();
        $query = User::with('role');

        if ($request->filled('name')) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->name . '%')
                    ->orWhere('middle_name', 'like', '%' . $request->name . '%')
                    ->orWhere('last_name', 'like', '%' . $request->name . '%');
            });
        }

        if ($request->filled('role')) {
            $query->where('roleID', $request->role);
        }

        $users = $query->get();

        return view('usersList', compact('users', 'roles'));
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'first_name'  => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name'   => 'required|string|max:255',
            'birth_date'  => 'nullable|date',
            'email'       => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone'       => 'nullable|string|max:255',
            'address'     => 'nullable|string|max:255',
            'roleID'      => 'required|exists:roles,id',
        ]);

        $user->update($validated);

        return redirect()->route('usersList')->with('success', 'Пользователь успешно обновлён.');
    }
}
