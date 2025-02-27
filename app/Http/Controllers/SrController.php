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

        if ($user->hasRole('dealer')) {
            $dealer_id = $user->dealer->id;
            $locationQuery->whereHas('sr', function ($query) use ($dealer_id) {
                $query->where('dealer_id', $dealer_id);
            });
            $srQuery->where('dealer_id', $dealer_id);
        }

        if ($sr_id) {
            $locationQuery->where('sr_id', $sr_id);
        }

        if ($time) {
            $endDate = now()->endOfDay();

            switch ($time) {
                case '1':
                    $currentDate = now()->toDateString();
                    $locationQuery->whereDate('created_at', $currentDate);
                    break;
                case '2':
                    $startDate = now()->subDays(1)->startOfDay();
                    $locationQuery->whereBetween('created_at', [$startDate, $endDate]);
                    break;
                case '3':
                    $startDate = now()->subDays(6)->startOfDay();
                    $locationQuery->whereBetween('created_at', [$startDate, $endDate]);
                    break;
                case '4':
                    $startDate = now()->subDays(14)->startOfDay();
                    $locationQuery->whereBetween('created_at', [$startDate, $endDate]);
                    break;
                case '5':
                    $startDate = now()->subDays(29)->startOfDay();
                    $locationQuery->whereBetween('created_at', [$startDate, $endDate]);
                    break;
                default:
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

        $srId = Session::get('sr_id');
        $from_date = Session::get('from_date');
        $to_date = Session::get('to_date');

        $attendanceQuery = Attendance::with('sr', 'retail');
        $srQuery = Sr::with('user');

        if ($user->hasRole('dealer')) {
            $dealer_id = $user->dealer->id;
            $attendanceQuery->whereHas('sr', function ($query) use ($dealer_id) {
                $query->where('dealer_id', $dealer_id);
            });
            $srQuery = $srQuery->where('dealer_id', $dealer_id);
        } elseif (($user->hasRole('field_force'))) {
            $sr_id = $user->sr->id;
            $attendanceQuery->where('sr_id', $sr_id);
            $srQuery = $srQuery->where('sr_id', $sr_id);
        }

        if ($srId) {
            $attendanceQuery->where('sr_id', $srId);
        }
        if (!empty($from_date)) {
            $attendanceQuery->whereDate('created_at', '>=', Carbon::parse($from_date));
        }
        if (!empty($to_date)) {
            $attendanceQuery->whereDate('created_at', '<=', Carbon::parse($to_date));
        }

        $attendances = $attendanceQuery->get();
        $srs = $srQuery->get();

        return view('sr.attendance', compact('attendances', 'srs'));
    }

    public function fieldForceAttendanceStore(Request $request)
    {
        $sr_id = $request->sr_id;
        $from_date = $request->from_date;
        $to_date = $request->to_date;

        Session::put([
            'sr_id' => $sr_id,
            'from_date' => $from_date,
            'to_date' => $to_date
        ]);

        return redirect()->route('admin.fieldForceAttendance');
    }

    public function attendanceLocation($id)
    {
        $location = Attendance::with('sr')->find($id);

        return view('map', [
            'lat' => $location->lat,
            'lon' => $location->lon,
            'name' => $location->sr->user->name ?? '',
            'id' => $location->sr->user->officeid ?? '',
        ]);
    }

    public function attendanceMonitoring()
    {
        $user = Auth::user();

        $sr_id = Session::get('sr_id');
        $type = Session::get('type');
        $from_date = Session::get('from_date');
        $to_date = Session::get('to_date');

        $status = [];
        $scheduleQuery = Srschedule::with('sr', 'retail', 'attendance');
        $srQuery = Sr::with('user');
        if ($user->hasRole('dealer')) {
            $dealer_id = $user->dealer->id;
            $scheduleQuery->whereHas('sr', function ($query) use ($dealer_id) {
                $query->where('dealer_id', $dealer_id);
            });
            $srQuery->where('dealer_id', $dealer_id);
        }

        if($sr_id){
            $scheduleQuery->where('sr_id',$sr_id);
        }
        if($from_date){
            $scheduleQuery->whereDate('visit_datetime','>=',$from_date);
        }
        if($to_date){
            $scheduleQuery->whereDate('visit_datetime','<=',$to_date);
        }
        if ($type) {
            switch ($type) {
                case '2': // Missed Visit
                    $scheduleQuery->whereDoesntHave('attendance')->where('visit_datetime', '<', now());
                    break;
                case '3': // Upcoming Schedule
                    $scheduleQuery->whereDoesntHave('attendance')->where('visit_datetime', '>', now());
                    break;
                case '4': // Late Visit
                    $scheduleQuery->whereHas('attendance', function ($q) {
                        $q->whereColumn('time', '>', 'srschedules.visit_datetime');
                    });
                    break;
                case '5': // On Time Visit
                    $scheduleQuery->whereHas('attendance', function ($q) {
                        $q->whereColumn('time', '<=', 'srschedules.visit_datetime');
                    });
                    break;
                default:
                    break; // '1' means All Schedule, so no filtering is applied
            }
        }


        $schedules = $scheduleQuery->get();
        $srs = $srQuery->get();

        foreach ($schedules as $schedule) {
            // Check if there is an attendance record
            if ($schedule->attendance) {
                $attendanceTime = $schedule->attendance->time;
                $visitDatetime = $schedule->visit_datetime;

                // Convert both attendance time and visit datetime to timestamps for accurate comparison
                if ($attendanceTime && strtotime($attendanceTime) > strtotime($visitDatetime)) {
                    $status[] = 'Late';
                } else {
                    $status[] = 'On Time';
                }
            } else {
                // Check if visit_datetime is in the future
                if (strtotime($schedule->visit_datetime) > time()) {
                    $status[] = 'Upcoming';
                } else {
                    $status[] = 'Missed';
                }
            }
        }


        // Pass both schedules and status to the view
        return view('report.attendance', compact('schedules', 'status','srs'));
    }

    public function monitoringSearch(Request $request)
    {
        $sr_id = $request->sr_id;
        $type = $request->type;
        $from_date = $request->from_date;
        $to_date = $request->to_date;

        Session::put([
            'sr_id' => $sr_id,
            'type' => $type,
            'from_date' => $from_date,
            'to_date' => $to_date
        ]);

        return redirect()->route('attendanceMonitoring');
    }






}
