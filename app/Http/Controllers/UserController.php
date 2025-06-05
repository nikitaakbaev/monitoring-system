<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
        return back() -> withInput();
    }
}
