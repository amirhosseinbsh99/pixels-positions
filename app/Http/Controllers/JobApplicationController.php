<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function store(Request $request, \App\Models\Job $job)
    {
        $user = auth()->user();

        if ($user->user_type !== 'jobseeker') {
            return redirect()->back()->with('error', 'Only job seekers can apply.');
        }

        // Optional: check if already applied
        if ($job->applications()->where('user_id', $user->id)->exists()) {
            return redirect()->back()->with('error', 'You have already applied to this job.');
        }

        $request->validate([
            'cover_letter' => 'nullable|string|max:2000'
        ]);

        $job->applications()->create([
            'user_id' => $user->id,
            'cover_letter' => $request->cover_letter,
        ]);

        return redirect()->back()->with('success', 'Your application has been submitted!');
    }

    
    public function applicants(\App\Models\Job $job)
    {
        $user = auth()->user();

        // Only allow if current user owns the job
        if ($user->user_type !== 'employer') {
            return redirect('/')->with('error', 'You are not authorized to view applicants for this job.');
        }

        // Load applications with user details
        $applications = $job->applications()->with('user')->latest()->get();

        return view('jobs.applicants', compact('job', 'applications'));
    }

}

