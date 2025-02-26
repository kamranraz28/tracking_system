<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Sr;
use App\Models\Srlocation;
use App\Models\Srschedule;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Session;

class SrController extends Controller
{
    //
    public function trackSr()
    {
        $sr_id = Session::get('sr_id');
        $time = Session::get('time');

        $user = Auth::user();

        $locationQuery = Srlocation::with('sr');
        $srQuery = Sr::with('user');

        if ($user->hasRole('dealer')){
            $dealer_id = $user->dealer->id;
            $locationQuery = $locationQuery->whereHas('sr', function ($query) use ($dealer_id) {
                $query->where('dealer_id', $dealer_id);
            });
            $srQuery = $srQuery->where('dealer_id', $dealer_id);
        }

        if($sr_id){
            $locationQuery = $locationQuery->where('sr_id',$sr_id);
        }

        if($time){
            $endDate = now()->endOfDay();

            switch($time){
                case '1' :
                    $currentDate = now()->toDateString();
                    $locationQuery = $locationQuery->whereDate('created_at',$currentDate);
                    break;
                case '2' :
                    $startDate = now()->subDays(1)->startOfDay();
                    $locationQuery = $locationQuery->whereBetween('created_at', [$startDate, $endDate]);
                    break;
                case '3' :
                    $startDate = now()->subDays(6)->startOfDay();
                    $locationQuery = $locationQuery->whereBetween('created_at', [$startDate, $endDate]);
                    break;
                case '4' :
                    $startDate = now()->subDays(14)->startOfDay();
                    $locationQuery = $locationQuery->whereBetween('created_at', [$startDate, $endDate]);
                    break;
                case '5' :
                    $startDate = now()->subDays(29)->startOfDay();
                    $locationQuery = $locationQuery->whereBetween('created_at', [$startDate, $endDate]);
                    break;
                default :
                    $locationQuery = [];
                    break;
            }
        }

        if (!$sr_id && !$time) {
            $locations = [];
        } else {
            $locations = $locationQuery->get();
        }
        $srs = $srQuery->get();


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


    public function fieldForceAttendance()
    {
        $user = Auth::user();

        $attendanceQuery = Attendance::with('sr','retail');

        if ($user->hasRole('dealer')){
            $dealer_id = $user->dealer->id;
            $attendanceQuery = $attendanceQuery->whereHas('sr', function ($query) use ($dealer_id) {
                $query->where('dealer_id', $dealer_id);
            });
        }elseif(($user->hasRole('field_force'))){
            $sr_id = $user->sr->id;
            $attendanceQuery = $attendanceQuery->where('sr_id',$sr_id);
        }

        $attendances = $attendanceQuery->get();

        return view('sr.attendance', compact('attendances'));
    }




}
