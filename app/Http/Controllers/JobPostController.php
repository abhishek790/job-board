<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use Illuminate\Http\Request;

class JobPostController extends Controller
{

    public function index(Request $request)
    {
        // only these query parameter will be sent as associative array to this variable
        $filters = request()->only('search', 'min_salary', 'max_salary', 'experience', 'category');



        return view('job.index', ['jobs' => JobPost::with('employer')->latest()->filter($filters)->get()]);
    }


    public function show(JobPost $job)
    {// by doing employer.jobPosts we are loading all the jobs from employer
        return view('job.show', ['job' => $job->load('employer.jobPosts')]);
    }


}
