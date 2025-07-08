<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\Category; 

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $jobs = Job::whereHas('employer')
        ->latest()
        ->with(['employer', 'tags'])
        ->get()
        ->groupBy('featured');
        return view('jobs.index', [
            'featuredjobs' => $jobs[1] ?? collect(),
            'jobs' => $jobs[0] ?? collect(),
            'tags' => Tag::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();

    if ($user->user_type !== 'employer') {
        return redirect('/')->with('error', 'Only employers can create jobs.');
    }
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
            'schedule' => ['required', Rule::in(['Part Time', 'Full Time'])],
            'url' => ['nullable', 'active_url'],
            'tags' => ['nullable'],
        ]);

        $attributes['featured'] = $request->has('featured');

        $user = Auth::user();

        // Check if user is employer before creating job
        if ($user->user_type !== 'employer') {
            abort(403, 'Only employers can create jobs.');
        }

        // Create the job linked to the employer user (employer_id points to users.id)
        $job = $user->jobs()->create(Arr::except($attributes, 'tags'));

        if (!empty($attributes['tags'])) {
            foreach (explode(',', $attributes['tags']) as $tag) {
                $job->tag(trim($tag));
            }
        }

        return redirect('/');
    }
    public function edit(Job $job)
    {
        $user = Auth::user();

        // Only allow employer to edit their own job
        if ($user->user_type !== 'employer' || $job->employer_id !== $user->id) {
            abort(403, 'Unauthorized access to edit this job.');
        }

        return view('jobs.edit', [
            'job' => $job,
            'categories' => Category::all(),
        ]);
    }
    public function update(Request $request, Job $job)
    {
        $user = Auth::user();

        // Only allow employer to update their own job
        if ($user->user_type !== 'employer' || $job->employer_id !== $user->id) {
            abort(403, 'Unauthorized access to update this job.');
        }

        $attributes = $request->validate([
            'title' => ['required'],
            'salary' => ['required'],
            'category_id' => ['required', 'exists:categories,id'],
            'location' => ['required'],
            'schedule' => ['required', Rule::in(['Part Time', 'Full Time'])],
            'url' => ['nullable', 'url'],
            'tags' => ['nullable'],
        ]);

        $attributes['featured'] = $request->has('featured');

        // Update job data
        $job->update(Arr::except($attributes, 'tags'));

        // Sync tags
        if (!empty($attributes['tags'])) {
            $tagIds = collect(explode(',', $attributes['tags']))
                ->map(fn($name) => Tag::firstOrCreate(['name' => trim($name)])->id)
                ->toArray();

            $job->tags()->sync($tagIds);
        } else {
            $job->tags()->detach();
        }

        return redirect()->route('jobs.myjobs')->with('success', 'Job updated successfully.');
    }
    public function destroy(Job $job)
    {
        $user = Auth::user();

        // Only the job’s owner (and only if they’re an employer) can delete
        if ($user->user_type !== 'employer' || $job->employer_id !== $user->id) {
            abort(403, 'You do not have permission to delete this job.');
        }

        // Detach tags / applications if you need to keep the pivot tables clean
        $job->tags()->detach();
        // $job->applications()->delete();  // uncomment if you want to cascade‑delete applications

        $job->delete();

        return redirect()
            ->route('employer.jobs')
            ->with('success', 'Job deleted successfully.');
    }



    /**
     * Display the specified resource.
     */
    public function brows()
    {
        $jobs = Job::with(['category', 'employer', 'tags'])->latest()->paginate(20);

        return view('brows', [
            'jobs' => $jobs,
            'tags' => Tag::all(),
        ]);
    }

    public function show(Job $job)
    {
        return view('jobs.job-detail', [
            'job' => $job,
        ]);
    }
    // app/Http/Controllers/JobController.php
    public function myJobs()
    {
        $user = Auth::user();

        // Only employers should reach this page
        abort_if($user->user_type !== 'employer', 403);

        // Pull just *this* employer’s jobs
        $jobs = $user->jobs()                // ← scoped to employer
            ->with(['tags', 'category'])     // eager‑load what you need
            ->latest()
            ->get()
            ->groupBy('featured');

        return view('jobs.my-jobs', [
            'featuredjobs' => $jobs[1] ?? collect(),
            'jobs'         => $jobs[0] ?? collect(),
        ]);
    }


}
