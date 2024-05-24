<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
  public function userHome()
  {
    $user = auth()->user();
    return view('content.user.home', compact('user'));
  }

  public function profile()
  {
    $user = auth()->user();
    return view('content.user.profile', compact('user'));
  }

  public function updateProfile(Request $request)
  {
    $user = auth()->user();

    $request->validate([
      'name' => 'required',
      'email' => 'required|email|unique:users,email,' . $user->id,
    ]);

    $user->update($request->all());

    if (auth()->user()->type == 1) {
      return redirect()
        ->route('content.admin.home')
        ->with('success', 'User profile updated successfully');
    } else {
      return redirect()
        ->route('content.user.home')
        ->with('success', 'Your profile updated successfully');
    }
  }

  public function edit($id)
  {
    $emails = User::pluck('email')->toArray(); // Get all emails
    $user = User::findOrFail($id);
    return view('content.user.edit', compact('user', 'emails'));
  }

  public function update(Request $request, $id)
  {
    $user = User::findOrFail($id);

    $request->validate([
      'name' => 'required|regex:/^[a-zA-Z\s]+$/',
      'email' => 'required|email|unique:users,email,' . $user->id,
    ]);

    $user->update($request->all());

    if (auth()->user()->type == 1) {
      return redirect()
        ->route('admin.home')
        ->with('success', 'Profile updated successfully');
    } else {
      return redirect()
        ->route('user.home', $user->id)
        ->with('success', 'Profile updated successfully');
    }
  }

  public function destroy($id)
  {
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()
      ->route('admin.home')
      ->with('success', 'User deleted successfully');
  }

  public function store(Request $request)
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
      'password' => bcrypt($request->password),
    ]);

    return redirect()
      ->route('admin.home')
      ->with('success', 'User registered successfully.');
  }

  public function showChangePasswordForm()
  {
    return view('content.user.ChangePassword');
  }

  public function changePassword(Request $request)
  {
    // Validate the request data
    $request->validate([
      'current_password' => 'required',
      'new_password' => ['required', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[a-zA-Z]).{8,}$/'],
      'new_password_confirmation' => 'required|same:new_password',
    ]);

    // Change the password
    auth()
      ->user()
      ->update([
        'password' => Hash::make($request->new_password),
      ]);

    return redirect('/user/home')->with('success', 'Password changed successfully');
  }

  public function verifyPassword(Request $request)
  {
    $currentPassword = $request->input('current_password');
    $user = Auth::user();

    if (Hash::check($currentPassword, $user->password)) {
      return response()->json(['valid' => true]);
    } else {
      return response()->json(['valid' => false]);
    }
  }
}
