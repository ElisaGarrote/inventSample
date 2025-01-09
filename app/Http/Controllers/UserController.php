<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log; 
use League\Config\Exception\ValidationException;// Ensure this import is here

class UserController extends Controller
{
    public function store(Request $request)
{
    try {
        // Validate request data
        $validated = $request->validate([
            'user_number' => 'required|unique:users|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:8',
            'contact_number' => 'required|string|max:15',
            'role' => 'required|string|in:admin,faculty',
            'status' => 'required|string|in:active,inactive',
        ]);

        // Create user
        $user = User::create([
            'user_number' => $validated['user_number'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'contact_number' => $validated['contact_number'],
            'role' => $validated['role'],
            'status' => $validated['status'],
        ]);

        // Return the created user
        return response()->json(['success' => true, 'user' => $user], 201);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json(['success' => false, 'errors' => $e->errors()], 422);
    } catch (\Exception $e) {
        Log::error('Error in UserController@store: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'An error occurred.'], 500);
    }
}
   
    public function list()
    {
        $books =Book::all();
        return response()->json(['books' => $books], 200);
    }
public function index()
    {
        $users = User::all();
        return view('admin.user_management', compact('users'));
    }

//Edit USer
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'user_number' => 'required|string|max:255',
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'contact_number' => 'required|string|max:255',
                'role' => 'required|string|in:admin,faculty',
                'status' => 'required|string|in:active,inactive',
            ]);

            $user = User::findOrFail($id);
            $user->update($validated);

            return response()->json([
                'success' => true,
                'user' => $user,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function delete($id)
    {
        try {
            // Find the user by ID
            $user = User::findOrFail($id);

            // Soft delete the user
            $user->delete();

            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            Log::error('Error in UserController@delete: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred while deleting the user.'], 500);
        }
    }

    public function destroy($id)
{
    Log::info('Destroy method called for user ID: ' . $id);

    try {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['success' => true, 'message' => 'User deleted successfully.']);
    } catch (\Exception $e) {
        Log::error('Error deleting user: ' . $e->getMessage());

        return response()->json(['success' => false, 'message' => 'Error deleting user.'], 500);
    }
}
}