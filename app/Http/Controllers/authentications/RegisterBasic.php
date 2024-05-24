<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterBasic extends Controller
{
  public function index()
  {
    $emails = User::pluck('email')->toArray(); // Get all emails
    return view('content.authentications.auth-register-basic', compact('emails'));
  }

  public function register(Request $request)
  {
    $request->validate([
      'name' => 'required|regex:/^[a-zA-Z\s]+$/',
      'email' => 'required|email|unique:users,email,',
      'password' => ['required', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[a-zA-Z]).{8,}$/'],
      'password_confirmation' => 'required|same:password',
    ]);
    $user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
    ]);

    Auth::login($user);

    return redirect('/')->with('success', 'You have successfully registered.');
  }
}
