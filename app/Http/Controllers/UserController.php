<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function showJobs(Request $request)
    {
        $userId = $request->user()->id;
        $user = User::find($userId);
        $jobs = $user->jobs;
        return response()->json([
            'jobs' => $jobs
        ]);
    }
}
