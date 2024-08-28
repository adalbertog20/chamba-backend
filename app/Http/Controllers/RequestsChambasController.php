<?php

namespace App\Http\Controllers;

use App\Enums\RequestStatus;
use App\Enums\StatusType;
use App\Models\RequestChamba;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;

class RequestsChambasController extends Controller
{
    public function getAllRequests()
    {
        $userId = auth()->user()->id;

        $requests = RequestChamba::all()->where('worker_id', $userId);

        return response()->json([
            'requests' => $requests,
            'message' => 'All requests'
        ]);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'client_id' => ['required', 'integer', 'exists:users,id'],
            'worker_id' => ['required', 'integer', 'exists:users,id'],
            'chamba_id' => ['required', 'integer', 'exists:chambas,id'],
            'message' => ['required', 'string'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
        ]);

        $request = RequestChamba::create([
            'client_id' => $validatedData['client_id'],
            'worker_id' => $validatedData['worker_id'],
            'chamba_id' => $validatedData['chamba_id'],
            'message' => $validatedData['message'],
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
        ]);

        return response()->json([
            'message' => 'Request created',
            'request' => $request
        ]);
    }
    public function updateStatus(Request $request, $id)
    {
        $requestChamba = RequestChamba::find($id);

        $validatedData = $request->validate([
            'status' => ['required', 'string', Rule::in([StatusType::Pending, StatusType::Accepted, StatusType::Rejected, StatusType::Ended])]
        ]);

        $requestChamba->update([
            'status' => $validatedData['status']
        ]);

        return response()->json([
            'message' => 'Request Status updated',
            'request' => $requestChamba
        ]);
    }
}
