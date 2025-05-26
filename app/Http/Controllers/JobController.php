<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = Job::latest()->with(['employer', 'tags'])->get()->groupBy('featured');

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

    // You can implement edit, update, destroy methods as needed
}
