<?php

namespace App\Http\Controllers;
use App\Models\JobPost;
use Illuminate\Http\Request;

class MyJobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view(
            'my_job.index',
            [
                'jobs' => auth()->user()->employer
                    ->jobPosts()
                    ->with('employer', 'jobApplications', 'jobApplications.user')
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('my_job.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'salary' => 'required|numeric|min:5000',
            'description' => 'required|string',
            // implode turns array into string first value is used as sperator in our case we have passed comma
            'experience' => 'required|in:' . implode(',', JobPost::$experience),
            'category' => 'required|in:' . implode(',', JobPost::$category),
        ]);
        // here we use employer as property instead of method because doing so will load the employer,however when method is used it won't load employer while user's are automatically loaded by laravel
        auth()->user()->employer->jobPosts()->create($validatedData);

        return redirect()->route('my-jobs.index')->with('success', 'Job created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
