<?php

namespace App\Http\Controllers;

use App\Models\Chamba;
use DB;
use Illuminate\Http\Request;

class ChambaController extends Controller
{
    public function index(Request $request)
    {
        $chambas = Chamba::all();
        return response()->json([
            "chambas" => $chambas
        ]);
    }
    public function show($id)
    {
        $chamba = DB::table('chambas')
            ->join('jobs', 'chambas.job_id', '=', 'jobs.id')
            ->join('users', 'chambas.worker_id', '=', 'users.id')
            ->select('chambas.*', 'jobs.name as job_name', 'users.name as worker_name')
            ->where('chambas.id', $id)
            ->first();

        return response()->json([
            "chamba" => $chamba
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'job_id' => ['required', 'string', 'exists:jobs,id'],
            'worker_id' => ['required', 'integer', 'exists:users,id'],
        ]);

        $chamba = Chamba::create($request->all());

        return response()->json([
            "message" => "Chamba Created Successfully",
            "chamba" => $chamba
        ]);
    }
    public function update(Request $request, $id)
    {

        $chamba = Chamba::where('id', $id)->firstOrFail();

        $validatedData = $request->validate([
            'title' => ['string', 'max:255'],
            'description' => ['string'],
            'job_id' => ['string', 'exists:jobs,id'],
            'worker_id' => ['integer', 'exists:users,id'],
        ]);

        $chamba->title = $validatedData['title'] ?? $chamba->title;
        $chamba->description = $validatedData['description'] ?? $chamba->description;
        $chamba->job_id = $validatedData['job_id'] ?? $chamba->job_id;
        $chamba->worker_id = $validatedData['worker_id'] ?? $chamba->worker_id;

        $chamba->save();

        return response()->json([
            "message" => "Chamba Updated Successfully",
            "chamba" => $chamba
        ]);
    }
    public function destroy($id)
    {
        $chamba = Chamba::find($id);
        $chamba->delete();

        return response()->json([
            "message" => "Chamba Deleted Successfully"
        ]);
    }
}