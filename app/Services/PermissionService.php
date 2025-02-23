<?php

namespace App\Services;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Request;
use Spatie\Permission\Models\Permission;

class PermissionService{

    public function getPermission()
    {
        $permissions = Permission::all();

        return [
            'permissions' => $permissions,
        ];
    }

    public function storePermission($request)
    {
        $id = Auth()->id();
        Permission::create(['name' => $request->name]);

        // Create a notification for user creation
        $notification = new Notification();
        $notification->user_id = null;
        $notification->message = Auth::user()->name . " created a perission- {$request->name}";
        $notification->is_read = false;
        $notification->created_by = $id;
        $notification->save();
    }

}