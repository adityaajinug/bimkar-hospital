<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        try {
            $request->authenticate();
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user->role === 'dokter') {
                return redirect()->intended(route('dokter.index'));
            } elseif ($user->role === 'pasien') {
                dd('test');
                return redirect()->intended(route('pasien.index'));
            }
            
        } catch (ValidationException $e) {
            Log::error(['error' => $e->getMessage()]);
            return back()->with([
                'status' => 'error',
                'message' => "Login is Not Successfully. Please try again."
            ]);
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login.index');
    }
}
