<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobRequest;
use App\Models\JobPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MyJobController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAnyEmployer', JobPost::class);
        return view(
            'my_job.index',
            [
                'jobs' => auth()->user()->employer
                    ->jobPosts()
                    ->with('employer', 'jobApplications', 'jobApplications.user')
                    ->get()
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', JobPost::class);
        return view('my_job.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobRequest $request)
    {
        Gate::authorize('create', JobPost::class);
        // here we use employer as property instead of method because doing so will load the employer,however when method is used it won't load employer while user's are automatically loaded by laravel
        auth()->user()->employer->jobPosts()->create($request->validated());

        return redirect()->route('my-jobs.index')->with('success', 'Job created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobPost $myJob)
    {
        Gate::authorize('update', $myJob);
        return view('my_job.edit', ['job' => $myJob]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobRequest $request, JobPost $myJob)
    {
        Gate::authorize('update', $myJob);
        $myJob->update($request->validated());

        return redirect()->route('my-jobs.index')
            ->with('success', 'Job updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobPost $myJob)
    {

        Gate::authorize('delete', $myJob);
        $myJob->delete();
        return redirect()->route('my-jobs.index')
            ->with('success', 'Job deleted successfylly');
    }

    public function trash()
    {
        return view('my_job.trash', [
            'jobs' => auth()->user()->employer
                // onlyTrashed will get all the trashed data
                ->jobPosts()->onlyTrashed()->get()
        ]);
    }

    public function restore($myJob)
    {
        // Gate::authorize('delete', $myJob);

        // this withTrashed will get both trashed data and not trashed , without withTrashed laravel won't find soft deleted data
        $myJob = JobPost::withTrashed()->find($myJob);
        $myJob->restore();

        return redirect()->route('my-jobs.index')
            ->with('success', 'Job restored successfylly');
    }

    public function forceDelete($myJob)
    {
        // Gate::authorize('delete', $myJob);
        $myJob = JobPost::withTrashed()->find($myJob);
        $myJob->forceDelete();
        return redirect()->route('my-jobs.index')
            ->with('success', 'Job deleted permanently');
    }
}
