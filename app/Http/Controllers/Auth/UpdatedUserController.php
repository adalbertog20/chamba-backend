<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Http\Controllers\Controller;
use Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UpdatedUserController extends Controller
{
    public function update(Request $request)
    {
        $user = $request->user();

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'min:10', 'max:12', Rule::unique('users')->ignore($user->id)],
            'street' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'min:5'],
            'city' => ['required', 'string', 'max:255', 'in:La Paz, San Jose del Cabo']
        ]);

        if (isset($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        $user->update($validatedData);

        return response()->json([
            'message' => 'User Updated Successfully',
            'user' => $user
        ]);
    }
    public function updatePassword(Request $request)
    {
        $user = $request->user();

        $validatedData = $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);

        $user->update([
            'password' => Hash::make($validatedData['password'])
        ]);

        return response()->json([
            'message' => 'Password Updated Successfully',
            'user' => $user
        ]);
    }
}
