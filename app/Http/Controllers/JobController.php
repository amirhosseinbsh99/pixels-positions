<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Http\Requests\StoreJobRequest;
use App\Http\Requests\UpdateJobRequest;
use App\Models\Tag;
use Arr;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = Job::latest()->with(['employer','tags'])->get()->groupBy('featured');
        
        return view('jobs.index',[
            'featuredjobs' => $jobs[1],
            'jobs'=> $jobs[0],
            'tags'=> Tag::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'title' => ['required'],
            'salary' => ['required'],
            'category_id' => ['required', 'exists:categories,id'],

            'location' => ['required'],
            'schedule' => ['required',Rule::in(['Part Time','Full Time'])],
            'url' => ['nullable','active_url'],
            'tags' => ['nullable'],
        ]);

        $attributes['featured'] = $request->has('featured');

        $job = \Illuminate\Support\Facades\Auth::user()->employer->jobs()->create(Arr::except($attributes,'tags'));

        if ($attributes['tags'] ?? false){
            foreach (explode(',',$attributes['tags']) as $tag){
                $job->tag($tag);
            }
        }
        return redirect('/');
    }

    /**
     * Display the specified resource.
     */
    public function brows(Job $job)
    {
        return view('brows', [
            'job' => $job, // ✅ Passing the single job for "show" method
            'jobs' => Job::with(['category', 'employer', 'tags'])->latest()->get(), // ✅ Fetching all jobs
            'tags' => Tag::all()
        ]);
    }
    public function show(Job $job)
    {
        // Return the view that shows the job details, passing the job as a variable
        return view('jobs.job-detail', [
        'job' => $job,
    ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $job)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobRequest $request, Job $job)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job)
    {
        //
    }
}
