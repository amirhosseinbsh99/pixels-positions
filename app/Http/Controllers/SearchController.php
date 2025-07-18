<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Tag;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = Job::with(['category', 'employer', 'tags'])->whereHas('employer');

        // Search by title
        if ($request->filled('q')) {
            $query->where('title', 'like', '%' . $request->q . '%');
        }

        // Filter by tag
        if ($request->filled('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('name', $request->tag);
            });
        }

        // Filter by schedule
        if ($request->filled('schedule')) {
            $query->where('schedule', $request->schedule);
        }

        // Filter by salary range
        if ($request->filled('salary')) {
            switch ($request->salary) {
                case '0-50,000':
                    $query->whereBetween('salary', [0, 50000]);
                    break;
                case '50,000-90,000':
                    $query->whereBetween('salary', [50000, 90000]);
                    break;
                case '90,000-150,000':
                    $query->whereBetween('salary', [90000, 150000]);
                    break;
                case '150,000+':
                    $query->where('salary', '>=', 150000);
                    break;
            }
        }

        // Filter by location
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }
        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Order by options
        if ($request->filled('order_by')) {
            switch ($request->order_by) {
                case 'salary_asc':
                    $query->orderBy('salary', 'asc');
                    break;
                case 'salary_desc':
                    $query->orderBy('salary', 'desc');
                    break;
                case 'title_asc':
                    $query->orderBy('title', 'asc');
                    break;
                case 'title_desc':
                    $query->orderBy('title', 'desc');
                    break;
                case 'date_asc':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'date_desc':
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            // Default sorting (latest)
            $query->latest();
        }

        // Exclude jobs posted by the job seeker
        if (auth()->check() && auth()->user()->user_type === 'job_seeker') {
            $query->where('employer_id', '!=', auth()->id());
        }

        // Final paginated result
        $jobs = $query->paginate(20)->withQueryString();

        return view('resualt', [
            'jobs' => $jobs,
            'tags' => Tag::all(),
        ]);
        
    }
}
