<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Srlocation;
use App\Models\Srschedule;
use Auth;
use Carbon\Carbon;
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
        ], 200);
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

        // Get the SR ID for the authenticated user
        $sr_id = $user->sr->id;

        // Fetch the schedule for the SR and retail on the same date as the input time
        $schedule = Srschedule::where('sr_id', $sr_id)
            ->where('retail_id', $request->retail_id)
            ->whereDate('visit_datetime', Carbon::parse($request->time)->toDateString())
            ->first();

        // Check if schedule exists
        if (!$schedule) {
            return response()->json([
                'status' => 'error',
                'message' => 'Schedule not found for the provided date and retail.'
            ], 404);
        }

        // Validate the incoming request
        $request->validate([
            'image' => 'required|file|mimes:jpeg,png,jpg,gif|max:2048', // Image validation
        ]);

        // Check if the file exists in the request
        if ($request->hasFile('image')) {
            // Retrieve the file
            $file = $request->file('image');

            // Generate a unique file name
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Move the file to the public/uploads directory
            $file->move(public_path('uploads'), $fileName);

            // Create the attendance record
            Attendance::create([
                'image' => $fileName,
                'sr_id' => $sr_id,
                'lat' => $request->input('lat'),
                'lon' => $request->input('lon'),
                'time' => $request->input('time'),
                'retail_id' => $request->input('retail_id'),
                'schedule_id' => $schedule->id ?? '',
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

        // If no file is uploaded
        return response()->json([
            'status' => 'error',
            'message' => 'No file uploaded',
        ], 400);
    }

}
