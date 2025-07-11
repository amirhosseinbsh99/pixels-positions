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

        if ($user->user_type !== 'employer' || $job->employer_id !== $user->id) {
            return redirect('/')->with('error', 'Not authorized.');
        }

        $applications = $job->applications()->with('user')->latest()->get();

        return view('jobs.applicants', compact('job', 'applications'));
    }

    public function myApplications()
    {
        $user = auth()->user();

        if ($user->user_type !== 'jobseeker') {
            return redirect('/')->with('error', 'Only job seekers can view their applications.');
        }

        // Get the jobs the user has applied to, with the application and job info
        $applications = $user->jobApplications()->with('job')->latest()->get();

        return view('jobs.my-applications', compact('applications'));
    }
    public function updateStatus(Request $request, \App\Models\JobApplication $application)
    {
        $user = auth()->user();

        // Check employer ownership
        if ($user->user_type !== 'employer' || $application->job->employer_id !== $user->id) {
            return redirect('/')->with('error', 'Not authorized.');
        }

        $request->validate([
            'status' => 'required|in:accepted,denied',
        ]);

        $application->status = $request->input('status');
        $application->save();

        return redirect()->back()->with('success', 'Application status updated successfully.');
    }

    public function cancel(\App\Models\JobApplication $application)
    {
        $user = auth()->user();

        if ($application->user_id !== $user->id) {
            return redirect()->back()->with('error', 'You are not authorized to cancel this application.');
        }

        // Optional: prevent canceling after accepted
        if ($application->status === 'accepted') {
            return redirect()->back()->with('error', 'You cannot cancel an accepted application.');
        }

        $application->delete();

        return redirect()->back()->with('success', 'Application canceled successfully.');
    }


}

