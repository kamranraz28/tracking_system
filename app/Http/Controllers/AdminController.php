<?php

namespace App\Http\Controllers;

use App\Models\Asm;
use App\Models\Dealer;
use App\Models\Division;
use App\Models\District;
use App\Models\Retail;
use App\Models\Tsm;
use App\Models\Upazila;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    //
    public function bulkUpload()
    {
        return view('admin.bulkUpload');
    }

    public function csvUpload(Request $request)
    {
        $type = $request->input('type');

        if ($type == 1) {

            $path = $request->file('csv_file')->getRealPath();
            $row_index = file($request->file('csv_file'), FILE_SKIP_EMPTY_LINES);
            $data = array_map('str_getcsv', file($path));
            $csv_data = array_slice($data, 1, count($row_index));

            foreach ($csv_data as $value) {
                $divisionName = trim($value[0]);
                $districtName = trim($value[1]);
                $upazilaName = trim($value[2]);
                $name = trim($value[3]);
                $email = trim($value[4]);
                $officeid = trim($value[5]);
                $contact = trim($value[6]);
                $address = trim($value[7]);
                $roleName = 'rsm';

                // 🔹 Find IDs from respective tables
                $division = Division::where('name', $divisionName)->first();
                $district = District::where('name', $districtName)->first();
                $upazila = Upazila::where('name', $upazilaName)->first();

                // 🔹 Create User (Check if the user already exists)
                $user = User::firstOrCreate(
                    [
                        'name' => $name,
                        'email' => $email,
                        'password' => Hash::make($officeid),
                        'division_id' => $division->id,
                        'district_id' => $district->id,
                        'upazila_id' => $upazila->id,
                        'officeid' => $officeid,
                        'contact' => $contact,
                        'address' => $address,
                        'level' => 200,
                    ]
                );

                // 🔹 Assign Role
                $user->assignRole($roleName);
            }

            return back()->with('success', 'Users uploaded successfully!');
        }

        if ($type == 2) {
            $path = $request->file('csv_file')->getRealPath();
            $row_index = file($request->file('csv_file'), FILE_SKIP_EMPTY_LINES);
            $data = array_map('str_getcsv', file($path));
            $csv_data = array_slice($data, 1, count($row_index));

            foreach ($csv_data as $value) {
                $divisionName = trim($value[0]);
                $districtName = trim($value[1]);
                $upazilaName = trim($value[2]);
                $name = trim($value[3]);
                $email = trim($value[4]);
                $officeid = trim($value[5]);
                $contact = trim($value[6]);
                $address = trim($value[7]);
                $rsmId = trim($value[8]);
                $roleName = 'asm';

                // 🔹 Find IDs from respective tables
                $division = Division::where('name', $divisionName)->first();
                $district = District::where('name', $districtName)->first();
                $upazila = Upazila::where('name', $upazilaName)->first();
                $rsm = User::where('officeid', $rsmId)->first();

                // 🔹 Create User (Check if the user already exists)
                $user = User::firstOrCreate(
                    [
                        'name' => $name,
                        'email' => $email,
                        'password' => Hash::make($officeid),
                        'division_id' => $division->id,
                        'district_id' => $district->id,
                        'upazila_id' => $upazila->id,
                        'officeid' => $officeid,
                        'contact' => $contact,
                        'address' => $address,
                        'level' => 300,
                    ]
                );

                // 🔹 Assign Role
                $user->assignRole($roleName);

                // 🔹 Create ASM
                Asm::create([
                    'user_id' => $user->id,
                    'rsm_id' => $rsm->id,
                ]);
            }

            return back()->with('success', 'Users uploaded successfully!');
        }
        if ($type == 3) {
            $path = $request->file('csv_file')->getRealPath();
            $row_index = file($request->file('csv_file'), FILE_SKIP_EMPTY_LINES);
            $data = array_map('str_getcsv', file($path));
            $csv_data = array_slice($data, 1, count($row_index));

            foreach ($csv_data as $value) {
                $divisionName = trim($value[0]);
                $districtName = trim($value[1]);
                $upazilaName = trim($value[2]);
                $name = trim($value[3]);
                $email = trim($value[4]);
                $officeid = trim($value[5]);
                $contact = trim($value[6]);
                $address = trim($value[7]);
                $asmId = trim($value[8]);
                $roleName = 'tsm';

                // 🔹 Find IDs from respective tables
                $division = Division::where('name', $divisionName)->first();
                $district = District::where('name', $districtName)->first();
                $upazila = Upazila::where('name', $upazilaName)->first();
                $asmUser = User::where('officeid', $asmId)->first();

                // 🔹 Create User (Check if the user already exists)
                $user = User::firstOrCreate(
                    [
                        'name' => $name,
                        'email' => $email,
                        'password' => Hash::make($officeid),
                        'division_id' => $division->id,
                        'district_id' => $district->id,
                        'upazila_id' => $upazila->id,
                        'officeid' => $officeid,
                        'contact' => $contact,
                        'address' => $address,
                        'level' => 400,
                    ]
                );

                // 🔹 Assign Role
                $user->assignRole($roleName);

                // 🔹 Create TSM
                Tsm::create([
                    'user_id' => $user->id,
                    'asm_id' => $asmUser->asm->id,
                ]);
            }

            return back()->with('success', 'Users uploaded successfully!');
        }

        if ($type == 4) {
            $path = $request->file('csv_file')->getRealPath();
            $row_index = file($request->file('csv_file'), FILE_SKIP_EMPTY_LINES);
            $data = array_map('str_getcsv', file($path));
            $csv_data = array_slice($data, 1, count($row_index));

            foreach ($csv_data as $value) {
                $divisionName = trim($value[0]);
                $districtName = trim($value[1]);
                $upazilaName = trim($value[2]);
                $name = trim($value[3]);
                $email = trim($value[4]);
                $officeid = trim($value[5]);
                $contact = trim($value[6]);
                $address = trim($value[7]);
                $tsmId = trim($value[8]);
                $roleName = 'dealer';

                // 🔹 Find IDs from respective tables
                $division = Division::where('name', $divisionName)->first();
                $district = District::where('name', $districtName)->first();
                $upazila = Upazila::where('name', $upazilaName)->first();
                $tsmUser = User::where('officeid', $tsmId)->first();

                // 🔹 Create User (Check if the user already exists)
                $user = User::firstOrCreate(
                    [
                        'name' => $name,
                        'email' => $email,
                        'password' => Hash::make($officeid),
                        'division_id' => $division->id,
                        'district_id' => $district->id,
                        'upazila_id' => $upazila->id,
                        'officeid' => $officeid,
                        'contact' => $contact,
                        'address' => $address,
                        'level' => 500,
                    ]
                );

                // 🔹 Assign Role
                $user->assignRole($roleName);

                // 🔹 Create Dealer
                Dealer::create([
                    'user_id' => $user->id,
                    'tsm_id' => $tsmUser->tsm->id,
                ]);
            }

            return back()->with('success', 'Users uploaded successfully!');
        }

        if ($type == 5) {
            $path = $request->file('csv_file')->getRealPath();
            $row_index = file($request->file('csv_file'), FILE_SKIP_EMPTY_LINES);
            $data = array_map('str_getcsv', file($path));
            $csv_data = array_slice($data, 1, count($row_index));

            foreach ($csv_data as $value) {
                $divisionName = trim($value[0]);
                $districtName = trim($value[1]);
                $upazilaName = trim($value[2]);
                $name = trim($value[3]);
                $email = trim($value[4]);
                $officeid = trim($value[5]);
                $contact = trim($value[6]);
                $address = trim($value[7]);
                $dealerId = trim($value[8]);
                $roleName = 'retail';

                // 🔹 Find IDs from respective tables
                $division = Division::where('name', $divisionName)->first();
                $district = District::where('name', $districtName)->first();
                $upazila = Upazila::where('name', $upazilaName)->first();
                $dealerUser = User::where('officeid', $dealerId)->first();

                // 🔹 Create User (Check if the user already exists)
                $user = User::firstOrCreate(
                    [
                        'name' => $name,
                        'email' => $email,
                        'password' => Hash::make($officeid),
                        'division_id' => $division->id,
                        'district_id' => $district->id,
                        'upazila_id' => $upazila->id,
                        'officeid' => $officeid,
                        'contact' => $contact,
                        'address' => $address,
                        'level' => 600,
                    ]
                );

                // 🔹 Assign Role
                $user->assignRole($roleName);

                // 🔹 Create Retail
                Retail::create([
                    'user_id' => $user->id,
                    'dealer_id' => $dealerUser->dealer->id,
                ]);
            }

            return back()->with('success', 'Users uploaded successfully!');
        }


    }

}
