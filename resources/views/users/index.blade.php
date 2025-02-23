@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="common-container">
    <h2>List of Users with Their Roles</h2>


    <div class="d-flex justify-content-end mb-4">
        <a class="btn btn-primary" href="{{ route('users.create') }}" style="background-color: {{ $buttonColor }};">
        <i class="fas fa-plus"> </i> Create User
        </a>
    </div>


    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Roles</th>
                <th>Action</th> <!-- Added Action column -->
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @foreach ($user->roles as $role)
                            <span>{{ $role->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        <!-- Action buttons: Edit and Delete -->
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning" style="background-color: {{ $buttonColor }};">Edit</a>

                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                            @csrf

                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
