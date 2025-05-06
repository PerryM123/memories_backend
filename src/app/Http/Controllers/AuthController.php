<?php

namespace App\Http\Controllers;

use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        Redis::set('test_key_again_log', 'Hello, Redis!');
        Log::info('login1:', ['request' => $request]);
        $credentials = $request->only('user_name', 'password');
        Log::info('login2:', ['credentials' => $credentials]);

        if (Auth::attempt($credentials)) {
            Log::info('attempt1:', ['credentials' => $credentials]);
            $request->session()->regenerate(); // Regenerates session ID to prevent fixation
            Log::info('attempt2');
            // Optionally store extra info in Redis-backed session
            Session::put('user_id', Auth::id());
            session()->save();
            Log::info('attempt33: ', ['Auth::id(): ', Auth::id()]);
            Log::info('attempt33: ', ['session()->all(): ', session()->all()]);
            return response()->json([
                'message' => 'Login successful',
                'user' => Auth::user(),
            ])->cookie(
                config('session.cookie'),
                session()->getId(),
                config('session.lifetime')
            );
        }

        Log::info('attempt4');
        return response()->json([
            'message' => 'Invalid credentials',
        ], 401);
    }
}
