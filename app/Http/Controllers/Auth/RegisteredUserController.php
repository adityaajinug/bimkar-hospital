<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        try {

            $request->validate([
                'nama'                  => ['required', 'string', 'max:255'],
                'email'                 => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'password'              => ['required', 'string', 'min:8'],
                'password_confirmation' => ['required', 'same:password'],
                'alamat'                => ['required', 'string', 'max:255'],
                'no_hp'                 => ['required', 'string', 'max:50'],
                'no_ktp'                => ['required', 'string', 'max:255'],
            ]);

            $existingPatient = User::where('no_ktp', $request->no_ktp)->first();
            if ($existingPatient) {
                throw ValidationException::withMessages([
                    'email' => trans('auth.failed'),
                ]);
            }
            $currentYearMonth = date('Ym');

            $patientCount = User::where('no_rm', 'like', $currentYearMonth . '-%')->count();
            $no_rm = $currentYearMonth . '-' . str_pad($patientCount + 1, 3, '0', STR_PAD_LEFT);
            
            User::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'pasien',
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'no_ktp' => $request->no_ktp,
                'no_rm' => $no_rm,
            ]);
            

            session([
                'status' => 'success',
                'message' => 'Registration successful! Please log in.'
            ]);
            
        } catch(\Exception $e) {
            Log::error(['error' => $e->getMessage()]);
            abort(400);
        }

        return redirect()->route('login.index');
    }
}
