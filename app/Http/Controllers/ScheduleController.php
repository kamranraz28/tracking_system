<?php

namespace App\Http\Controllers;

use App\Models\Retail;
use App\Models\Retaillocation;
use App\Models\Sr;
use App\Models\Srschedule;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Session;

class ScheduleController extends Controller
{
    //

    public function schedules()
    {
        // Get the session values for sr_id and time
        $srId = Session::get('sr_id');
        $time = Session::get('time');

        // Get the current authenticated user and dealer ID
        $user = Auth::user();

        $scheduleQuery = Srschedule::with('sr', 'retail');
        $srQuery = Sr::with('user', 'dealer');

        if ($user->hasRole('dealer')) {
            $dealer_id = $user->dealer->id;
            $scheduleQuery->whereHas('sr', function ($query) use ($dealer_id) {
                $query->where('dealer_id', $dealer_id);
            });
            $srQuery->where('dealer_id', $dealer_id);
        } elseif ($user->hasRole('field_force')) {
            $sr_id = $user->sr->id;
            $scheduleQuery->where('sr_id', $sr_id);
            $srQuery->where('dealer_id', $sr_id);
        }

        // Apply the time-based filters if provided
        if ($time) {
            $today = Carbon::today();

            switch ($time) {
                case '1': // Today's Schedules
                    $scheduleQuery->whereDate('visit_datetime', $today);
                    break;
                case '2': // Next 2 Days Schedules
                    $scheduleQuery->whereBetween('visit_datetime', [$today, $today->copy()->addDays(2)]);
                    break;
                case '3': // Next 7 Days Schedules
                    $scheduleQuery->whereBetween('visit_datetime', [$today, $today->copy()->addDays(7)]);
                    break;
                case '4': // Next 15 Days Schedules
                    $scheduleQuery->whereBetween('visit_datetime', [$today, $today->copy()->addDays(15)]);
                    break;
                case '5':
                    // No additional filter for '5', so nothing here
                    break;
                default:
                    break;
            }
        }

        // Apply sr_id filter if provided
        if ($srId) {
            $scheduleQuery->where('sr_id', $srId);
        }

        $schedules = $scheduleQuery->get();
        $srs = $srQuery->get();

        // Return the view with schedules and SRs
        return view('schedule.index', compact('schedules', 'srs'));
    }

    public function scheduleSearch(Request $request)
    {
        $sr_id = $request->input('sr_id');
        $time = $request->input('time');

        Session::put(['sr_id' => $sr_id, 'time' => $time]);

        return redirect()->route('schedules');
    }

    public function scheduleCreate()
    {
        $user = Auth::user();
        $dealer_id = $user->dealer->id;
        $srs = Sr::with('user')->where('dealer_id', $dealer_id)->get();
        $retails = Retail::with('user')->where('dealer_id', $dealer_id)->get();
        return view('schedule.create', compact('srs', 'retails'));
    }

    public function ScheduleStore(Request $request)
    {
        Srschedule::create([
            'sr_id' => $request->sr_id,
            'retail_id' => $request->retail_id,
            'visit_datetime' => $request->visit_datetime,
        ]);

        return redirect()->route('dealer.schedule')->with('success', ' Schedule created successfully!');
    }

    public function scheduleDelete($id)
    {
        Srschedule::find($id)->delete();

        return redirect()->back()->with('success', ' Schedule Deleted Successfully!');
    }

    public function scheduleEdit($id)
    {
        $schedule = Srschedule::with('sr', 'retail')->findOrFail($id);
        $srs = Sr::with('user')->get();
        $retails = Retail::with('user')->get();
        return view('schedule.edit', compact('schedule', 'srs', 'retails'));
    }

    public function scheduleUpdate(Request $request, $id)
    {
        $request->validate([
            'sr_id' => 'required|exists:srs,id',
            'retail_id' => 'required|exists:retails,id',
            'visit_datetime' => 'required|date',
        ]);

        Srschedule::findOrFail($id)->update([
            'sr_id' => $request->sr_id,
            'retail_id' => $request->retail_id,
            'visit_datetime' => $request->visit_datetime,
        ]);

        return redirect()->route('schedules')->with('success', 'Schedule updated successfully!');
    }

    public function mapView($id)
    {
        // Find the location by id
        $location = Retaillocation::with('retail')->find($id);

        if (!$location) {
            return redirect()->back()->with('error', 'Location not found!');
        }

        // Pass only the lat and lon values to the view
        return view('map', [
            'lat' => $location->lat,
            'lon' => $location->lon,
            'name' => $location->retail->user->name ?? '',
            'id' => $location->retail->user->officeid ?? '',
        ]);
    }


}
