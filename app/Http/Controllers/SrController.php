<?php

namespace App\Http\Controllers;

use App\Models\Sr;
use App\Models\Srlocation;
use Auth;
use Illuminate\Http\Request;
use Session;

class SrController extends Controller
{
    //
    public function trackSr()
    {
        $sr_id = Session::get('sr_id');
        $time = Session::get('time');

        if ($sr_id) {
            if ($time === '1') { // Today
                $currentDate = now()->toDateString(); // Use toDateString() for clarity
                $locations = Srlocation::where('sr_id', $sr_id)
                    ->whereDate('created_at', $currentDate)
                    ->get();
            } elseif ($time === '2') { // Last two days
                $startDate = now()->subDays(1)->startOfDay();
                $endDate = now()->endOfDay();
                $locations = Srlocation::where('sr_id', $sr_id)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->get();
            } elseif ($time === '3') { // Last 7 days
                $startDate = now()->subDays(6)->startOfDay();
                $endDate = now()->endOfDay();
                $locations = Srlocation::where('sr_id', $sr_id)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->get();
            } elseif ($time === '4') { // Last 15 days
                $startDate = now()->subDays(14)->startOfDay(); // 14 days ago
                $endDate = now()->endOfDay();
                $locations = Srlocation::where('sr_id', $sr_id)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->get();
            } elseif ($time === '5') { // Last 30 days (1 month)
                $startDate = now()->subDays(29)->startOfDay(); // 29 days ago
                $endDate = now()->endOfDay();
                $locations = Srlocation::where('sr_id', $sr_id)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->get();
            } else {
                $locations = [];
            }
        } else {
            $locations = [];
        }

        $srs = Sr::with('user')->get();

        return view('sr.index', compact('locations', 'srs'));
    }



    public function trackSrStore(Request $request)
    {
        $sr_id = $request->input('sr_id');
        $time = $request->input('time');

        Session::put(['sr_id' => $sr_id, 'time' => $time]);

        return redirect()->route('admin.trackSr');

    }

    public function trackSrMap(Request $request)
    {
        // Retrieve session values
        $srId = $request->session()->get('sr_id');
        $time = $request->session()->get('time');

        $locations = Srlocation::query();


        if ($srId) {
            $locations->where('sr_id', $srId);
        }

        if ($time) {
            switch ($time) {
                case '1': // Today
                    $locations->whereDate('created_at', now()->toDateString());
                    break;

                case '2': // Last two days
                    $locations->where('created_at', '>=', now()->subDays(1)->startOfDay());
                    break;

                case '3': // Last week (7 days)
                    $locations->where('created_at', '>=', now()->subDays(6)->startOfDay());
                    break;

                case '4': // Last 15 days
                    $locations->where('created_at', '>=', now()->subDays(14)->startOfDay());
                    break;

                case '5': // Last 30 days
                    $locations->where('created_at', '>=', now()->subDays(29)->startOfDay());
                    break;

                default:
                    // Optionally handle invalid time cases
                    break;
            }
        }

        $locations = $locations->get();

        return view('sr.trackMap', compact('locations'));
    }


}
