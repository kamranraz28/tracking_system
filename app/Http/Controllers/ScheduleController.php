<?php

namespace App\Http\Controllers;

use App\Models\Retail;
use App\Models\Retaillocation;
use App\Models\Sr;
use App\Models\Srschedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    //

    public function scheduleList()
    {
        $schedules = Srschedule::with('sr', 'retail')->get();
        return view('schedule.index', compact('schedules'));
    }
    public function scheduleCreate()
    {
        $srs = Sr::with('user')->get();
        $retails = Retail::with('user')->get();
        return view('schedule.create', compact('srs', 'retails'));
    }

    public function ScheduleStore(Request $request)
    {
        Srschedule::create([
            'sr_id' => $request->sr_id,
            'retail_id' => $request->retail_id,
            'visit_datetime' => $request->visit_datetime,
        ]);

        return redirect()->route('sr.schedule')->with('success', ' Schedule created successfully!');
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

        return redirect()->route('sr.schedule')->with('success', 'Schedule updated successfully!');
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
