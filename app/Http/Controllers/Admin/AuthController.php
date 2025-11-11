<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('templates.template1.frontend.auth.login');
    }
    public function login(Request $request)
    {
        // dd('hello');
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid email or password.'
            ]);
        }

        Auth::login($user);
        return response()->json([
            'status' => true,
            'message' => 'Login successful.',
            'redirect' => route('admin.index')
        ]);
    }
    public function logout(Request $request)
    {
        $user = Auth::user();
        Auth::logout($user);
        $request->session()->invalidate();
        return redirect()->route('login');
    }
    public function forgetPassword()
    {
        // 
    }
    public function showRegister()
    {
        //
    }
    public function register(Request $request)
    {
        // 
    }
}
