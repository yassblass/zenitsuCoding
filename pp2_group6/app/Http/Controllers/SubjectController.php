<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    //

    public function get(Request $request)
    {
        $subjects = Subject::all();
        return response()->json($subjects);
    }
}
