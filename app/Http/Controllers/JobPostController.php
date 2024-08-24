<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use App\Models\JobPost;
use Illuminate\Http\Request;

class JobPostController extends Controller
{

    public function index(Request $request)
    {
        // for all the operations,for all the authorization checks, which don't really have an argument that is an object,you have to specify a class
        Gate::authorize('viewAny', JobPost::class);
        // only these query parameter will be sent as associative array to this variable
        $filters = request()->only('search', 'min_salary', 'max_salary', 'experience', 'category');

        return view('job.index', ['jobs' => JobPost::with('employer')->latest()->filter($filters)->get()]);
    }


    public function show(JobPost $job)
    {
        Gate::authorize('view', $job);
        // by doing employer.jobPosts we are loading all the jobs from employer
        return view('job.show', ['job' => $job->load('employer.jobPosts')]);
    }


}
