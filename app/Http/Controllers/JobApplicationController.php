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
        $job->jobApplications()->create([
            'user_id' => $request->user()->id,
            ...$request->validate([
                'expected_salary' => 'required|min:1|max:1000000'
            ])
        ]);

        return redirect()->route('jobs.show', $job)->with('success', 'Job Application submitted');
    }


    public function destroy(string $id)
    {
        //
    }
}
