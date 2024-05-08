<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // return redirect()->intended(route('dashboard', absolute: false));
        //changing users directory after loggin in based on ther orle of the suer(user or admin)
        switch ($request->user()->role) {
            case 'admin':
                $url = '/profile';
                break;
            case 'user':
                $url = "/dashboard";
                break;
            default:
                $url = "";
                break;
        }

        return redirect()->intended($url);
    }

    /**
     * Destroy an authenticated session.
     */

     //when you log out you are automatically redirected to the login page,but what if you decede to redirect it to another page?,,,,please change here
     public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        //return redirect('/');

        //redirect to the registered page
        return redirect('/register');
    }
}
