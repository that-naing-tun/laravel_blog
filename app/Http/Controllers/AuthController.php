<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store()
    {
        //validate method is if user failed to login validate redirect login page else work continous
        $formdata = request()->validate([
            'name' => ['required', 'max:255', 'min:3'],
            'username' => ['required', 'max:255', 'min:3', Rule::unique('users', 'username')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8']
        ]);

        // dd($formdata);

        $user = User::create($formdata);
        auth()->login($user);
        session()->flash('success', 'WellCome, ' . $user->name);
        return redirect('/');
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/')->with('success', 'GoodBye');
    }

    public function post_login()
    {
        $formdata = request()->validate([
            'email' => ['required', 'email', 'max:255', Rule::exists('users', 'email')],
            'password' => ['required', 'min:8', 'max:255']

        ], [
            'email.required' => 'You need your valid email address',
            'password.min' => 'You Need Your Password Character is at least 8'
        ]);

        if (auth()->attempt($formdata)) {
            return redirect('/')->with('success', 'Login Successful');
        } else {
            return redirect()->back()->withErrors(['email' => 'Your Data is wrong']);
        }
    }

    public function login()
    {
        return view('auth.login');
    }
}
