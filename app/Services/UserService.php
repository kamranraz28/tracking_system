<?php

namespace App\Services;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserProfileRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;




class UserService
{
    public function getAllUsers()
    {

        $users = User::with('roles')->get();

        return $users;
    }

    public function storeUser(StoreUserRequest $request)
    {
        $id = Auth()->id();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

 
        $notification = new Notification();
        $notification->user_id = $user->id;
        $notification->message = Auth::user()->name . " created a user- {$user->name} for role- {$request->role}";
        $notification->is_read = false;
        $notification->created_by = $id;
        $notification->save();

        return $user;
    }

    public function updateUser(UpdateUserRequest $request, $id)
    {
        // Find the user
        $user = User::findOrFail($id);

        // Update user information
        $user->name = $request->name;
        $user->email = $request->email;

        // Update password only if it's provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Save the user
        $user->save();

        // Sync the user's roles
        $user->syncRoles($request->role);

        return $user;
    }


    public function getUserProfile()
    {
        $userId = Auth::id(); // Get the authenticated user's ID
        
        // Retrieve the user with roles
        $user = User::with('roles')->findOrFail($userId);
        $roles = Role::all();

        return compact('user', 'roles'); // Return user and roles
    }

    public function editUser($id)
    {
        // Fetch the user to edit
        $user = User::findOrFail($id);
        $roles = Role::all();

        return compact('user','roles');
    }

    public function updateUserProfile(UpdateUserProfileRequest $request)
    {
        $id = Auth()->id(); // Get the authenticated user's ID
        // Find the user by ID
        $user = User::findOrFail($id);

        // Update user details
        $user->name = $request->name;
        $user->email = $request->email;

        // Update password if provided
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Get the current date to append
            $currentDate = now()->format('YmdHis'); // Use a format suitable for filenames

            // Create a new filename in the format: idimagecurrentdate.extension
            $filename = "{$id}image{$currentDate}." . $request->file('image')->getClientOriginalExtension();

            // Store the image in the 'public/img' directory
            $path = $request->file('image')->storeAs('img', $filename, 'public'); // This stores in storage/app/public/img

            // Store the filename in the database (store the path for retrieval)
            $user->image = $filename; // Assuming you have an `image` column in your users table
        }

        $user->save();
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
    }


    public function updateSoftLogo(Request $request)
    {
        if ($request->hasFile('image')) {
            // Define the fixed filename and get the original extension
            $extension = $request->file('image')->getClientOriginalExtension();
            $filename = "softwareLogo." . $extension; // Fixed name with the original extension

            $filePath = 'img/' . $filename;

            // Check if the file already exists and delete it
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }

            // Store the new image
            $path = $request->file('image')->storeAs('img', $filename, 'public');
        }
    }



}
