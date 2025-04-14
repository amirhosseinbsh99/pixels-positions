<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Tag;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search()
    {
        $query = Job::with(['category', 'employer', 'tags']);

        // Search by title
        if (request()->has('q') && request('q') !== '') {
            $query->where('title', 'LIKE', '%' . request('q') . '%');
        }

        // Search by tag
        if (request()->has('tag') && request('tag') !== '') {
            $query->whereHas('tags', function ($q) {
                $q->where('name', request('tag'));
            });
        }

        // Search by schedule (e.g., Full-Time, Part-Time, Remote)
        if (request()->has('schedule') && request('schedule') !== '') {
            $query->where('schedule', request('schedule'));
        }
        
        // Filter by Salary Range
        if (request()->has('salary') && request('salary') !== '') {
            $salary = request('salary');
            if ($salary == '0-50,000') {
                $query->whereBetween('salary', [0, 50000]);
            } elseif ($salary == '50,000-90,000') {
                $query->whereBetween('salary', [50000, 90000]);
            } elseif ($salary == '90,000-150,000') {
                $query->whereBetween('salary', [90000, 150000]);
            } elseif ($salary == '150,000+') {
                $query->where('salary', '>=', 150000);
            }
        }

         // Filter by Location
         if (request()->has('location') && request('location') !== '') {
            $location = request('location');
            $query->where('location', 'LIKE', '%' . $location . '%');
        }

         // Apply ordering based on selected option
        if (request()->has('order_by') && request('order_by') !== '') {
        $orderBy = request('order_by');

        switch ($orderBy) {
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
            case 'date_desc':
                $query->orderBy('created_at', 'desc');
                break;
            case 'date_asc':
                $query->orderBy('created_at', 'asc');
                break;
            default:
                break;
        }
    }


        // Paginate the results
        $jobs = $query->latest()->paginate(20);

        return view('resualt', [
            'jobs' => $jobs,
            'tags' => Tag::all()
        ]);
    }
}
