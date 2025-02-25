<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Srlocation;
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
}
