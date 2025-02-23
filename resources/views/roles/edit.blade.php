@extends('layouts.master')

@section('title', 'Edit Role')

@section('content')

<div class="common-container">
    <h2>Edit Role</h2>

    <!-- Edit role form starts -->
    <form action="{{ route('roles.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Role Name Field -->
        <div class="form-group">
            <label for="name">Role Name:</label>
            <input type="text" id="name" name="name" value="{{ old('name', $role->name) }}" class="form-control" required>
        </div>

        <!-- Permissions Table -->
        <table id="example" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Permission Name</th>
                    <th>Select</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($permissions as $permission)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        
                        <td>{{ $permission->name }}</td>

                        <td>
                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" 
                            {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Submit Button -->
        <div class="col-12 text-center mt-4">
        <button type="submit" class="btn btn-primary" style="background-color: {{ $buttonColor }};">Update Role</button>
        </div>
    </form>
    <!-- Edit role form ends -->

</div>

@endsection
