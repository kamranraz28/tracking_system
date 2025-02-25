<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserProfileRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Dealer;
use App\Models\Retail;
use App\Models\Sr;
use App\Models\Srlocation;
use App\Models\Srschedule;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use App\Services\UserService;
use App\Http\Requests\StoreUserRequest;
use App\Models\Settings;
use Carbon\Carbon;


class UserController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function index()
    {
        $users = $this->userService->getAllUsers();

        return view('users.index', ['users' => $users]);
    }



    public function dashboard()
    {
        $userTotal = User::count();
        $srTotal = Sr::count();
        $retailTotal = Retail::count();
        $dealerTotal = Dealer::count();
        $location = Srlocation::count();
        $totalSchedule = Srschedule::count();

        // Get today's date without time
        $today = Carbon::today();

        // Get today's schedule count (Only schedules for today)
        $todaySchedule = Srschedule::whereDate('visit_datetime', $today)->count();

        // Get past schedules count (Strictly before today)
        $closeSchedule = Srschedule::whereDate('visit_datetime', '<', $today)->count();

        // Get upcoming schedules count (Strictly after today)
        $upcomingSchedule = Srschedule::whereDate('visit_datetime', '>', $today)->count();

        return view('dashboard', compact('upcomingSchedule', 'closeSchedule', 'totalSchedule', 'todaySchedule', 'userTotal', 'location', 'srTotal', 'retailTotal', 'dealerTotal'));
    }


    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        $this->userService->storeUser($request);

        return redirect()->back()->with('success', 'User created and role assigned successfully!');
    }


    public function edit($id)
    {
        $data = $this->userService->editUser($id);
        return view('users.edit', $data);
    }

    public function update(UpdateUserRequest $request, $id)
    {

        $this->userService->updateUser($request, $id);
        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }


    public function viewProfile()
    {
        // Call the service to get the user's profile
        $data = $this->userService->getUserProfile();

        return view('users.profile', $data); // Pass data to the view
    }


    public function updateProfile(UpdateUserProfileRequest $request)
    {
        $this->userService->updateUserProfile($request);
        return redirect()->route('users.dashboard')->with('success', 'Profile updated successfully!');
    }

    public function destroy($id)
    {
        $this->userService->deleteUser($id);
        return redirect()->route('users.index')->with('success', 'User Deleted successfully!');
    }

    public function clearAll()
    {
        Notification::query()->update(['notifiable_id' => 1]);

        return redirect()->back()->with('success', 'All notifications have been marked as read.');
    }

    public function logoChangeView()
    {
        return view('users.logoChange');
    }

    public function logoUpdate(Request $request)
    {
        $this->userService->updateSoftLogo($request);
        return redirect()->back()->with('success', 'Application logo has successfully changed.');

    }

    public function colorChangeView()
    {
        return view('users.colorChange');
    }

    public function updateColors(Request $request)
    {
        $request->validate([
            'headerColor' => 'required|string',
            'sidebarColor' => 'required|string',
            'buttonColor' => 'required|string',
        ]);
        // dd($request->all());

        // Save the colors in the settings table
        $settings = Settings::first();
        if (!$settings) {
            $settings = new Settings();
        }

        $settings->header_color = $request->input('headerColor');
        $settings->sidebar_color = $request->input('sidebarColor');
        $settings->button_color = $request->input('buttonColor');
        $settings->save();

        return back()->with('success', 'Colors updated successfully!');
    }






}
