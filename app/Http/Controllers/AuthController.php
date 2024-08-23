<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function create()
    {
        return view('auth.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        //fitering out certain value from the request
        $credentials = $request->only('email', 'password');


        //what filled does is, it will return true if specific value is present or is submitted with the form
        //now the way checkboxes work is if a checkbox won't be checked, the value won't be sent at all, so basically filled will check if this value is present which means it was being checked by the user
        $remember = $request->filled('remember');

        // now this attempt accepts 2 parameter, an array of credentials and remember which would authenticate user indefinitely unless user manually logs out, it value is set to false by default
        if (Auth::attempt($credentials, $remember)) {
            // this intended method is used for redirecting users back to the URL they originally intended to access before being redirected to another page, typically for authentication or authorization purposes
            return redirect()->intended('/');
        } else {
            return redirect()->back()->with('error', 'Invalid credentials');
        }
    }


    public function destroy()
    {
        //to logout we don't need any user id because laravel will just know what's the current user session by using the cookie

        Auth::logout();

        // this would basically invalidate the user session which means it will clear out all the data that's stored in the user session
        request()->session()->invalidate();

        // this will regenerate the csrf token for this session, so by regenerating this token, we basically make sure that all the forms that were loaded before the user signed out can't be successfully sent
        request()->session()->regenerateToken();

        return redirect()->route('auth.create');
    }
}
