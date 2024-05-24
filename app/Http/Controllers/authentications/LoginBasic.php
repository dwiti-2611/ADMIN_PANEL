<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;

class LoginBasic extends Controller
{
  public function index()
  {
    return view('content.authentications.auth-login-basic');
  }

  public function login(Request $request): RedirectResponse
  {
    $input = $request->all();

    $this->validate($request, [
      'email' => 'required|email|exists:users,email',
      'password' => 'required',
    ]);

    if (Auth::attempt(['email' => $input['email'], 'password' => $input['password']])) {
      $user = Auth::user();

      if ($user->type == 'admin') {
        return redirect()
          ->route('admin.home')
          ->with('success', 'You have logged in successfully!');
      } else {
        return redirect()
          ->route('user.home')
          ->with('success', 'You have logged in successfully!');
      }
    } else {
      return redirect()
        ->back()
        ->withErrors(['email' => 'Invalid Password or EmailAddress']);
    }
  }

  public function logout()
  {
    Session::flush();
    Auth::logout();
    return redirect('/');
  }
}
