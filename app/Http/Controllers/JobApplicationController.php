<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class JobApplicationController extends Controller
{

    public function create(JobPost $job)
    {
        Gate::authorize('apply', $job);
        return view('job_application.create', ['job' => $job]);
    }


    public function store(JobPost $job, Request $request)
    {
        Gate::authorize('apply', $job);

        $validatedData = $request->validate([
            'expected_salary' => 'required|min:1|max:1000000',
            'cv' => 'required|file|mimes:pdf|max:2048'
        ]);

        $file = $request->file('cv');
        // this file variable have store method and it allows you to store file into specific folder under specific disk, for eg: storing file in cvs directory inside a private disk
        $path = $file->store('cvs', 'private');

        $job->jobApplications()->create([
            'user_id' => $request->user()->id,
            'expected_salary' => $validatedData['expected_salary'],
            'cv_path' => $path

        ]);

        return redirect()->route('jobs.show', $job)->with('success', 'Job Application submitted');
    }


    public function destroy(string $id)
    {
        //
    }
}
