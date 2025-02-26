<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Srlocation;
use Auth;
use Illuminate\Http\Request;

class SrController extends Controller
{
    //
    public function locationStore(Request $request)
    {
        Srlocation::create([
            'sr_id' => $request->sr_id,
            'lat' => $request->lat,
            'lon' => $request->lon
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Sr location stored successfully.'
        ],200);
    }

    public function attendanceStore(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not authenticated.'
            ], 401);
        }
        $sr_id = $user->sr->id;

        // Validate the incoming request
        $request->validate([
            'image' => 'required|file|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Check if the file exists in the request
        if ($request->hasFile('image')) {
            // Retrieve the file
            $file = $request->file('image');

            // Generate a unique file name
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Move the file to the public/uploads directory
            $file->move(public_path('uploads'), $fileName);

            // Save the file name in the database
            Attendance::create([
                'image' => $fileName,
                'sr_id' => $sr_id,
                'lat' => $request->input('lat'),
                'lon' => $request->input('lon'),
                'time' => $request->input('time'),
                'retail_id' => $request->input('retail_id'),
            ]);

            // Return a success response
            return response()->json([
                'status' => 'success',
                'message' => 'Attendance submitted successfully',
                'data' => [
                    'time' => $request->input('time'),
                    'file_name' => $fileName,
                ],
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'No file uploaded',
        ], 400);
    }
}
