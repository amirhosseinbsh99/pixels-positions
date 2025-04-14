<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function __invoke(Tag $tag)
    {
        // Paginate the jobs related to the tag
        $jobs = $tag->jobs()->paginate(20);

        return view('resualt', ['jobs' => $jobs]);
    }
}
