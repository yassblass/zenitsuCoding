<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    //

    public function get(Request $request)
    {
        $subjects = Subject::orderBy('created_at', 'desc')->get();
        return response()->json($subjects);
    }
}
