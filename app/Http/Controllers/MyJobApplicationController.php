<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use Illuminate\Http\Request;

class MyJobApplicationController extends Controller
{

    public function index()
    {
        return view('my_job_applications.index', [
            'applications' => auth()->user()->jobApplications()
                ->with([
                    'jobPost' => fn($query) => $query->withCount('jobApplications')
                        ->withAvg('jobApplications', 'expected_salary'),
                    'jobPost.employer'
                ])
                ->latest()->get()
        ]);
    }


    public function destroy(JobApplication $myJobApplication)
    {
        $myJobApplication->delete();
        return redirect()->back()->with('success', 'Job application removed');
    }
}
