<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EmployerController extends Controller
{


    public function create()
    {
        Gate::authorize('create');
        return view('employer.create');
    }


    public function store(Request $request)
    {
        auth()->user()->employer()->create(
            $request->validate([
                // what(unique:employers,company_name) this does is ,it will make sure company name is unique on employers table
                'company_name' => 'required|min:3|unique:employers,company_name'
            ])
        );
        return redirect()->route('jobs.index')->with('success', 'Your employer account is created');
    }


}
