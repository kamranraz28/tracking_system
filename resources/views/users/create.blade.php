@extends('layouts.master')

@section('title', 'Create User')

@section('content')

<div class="common-container container mt-4">

    <h2 class="text-center mb-4">Create User and Assign Role</h2>

    @if (session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('store.user') }}" method="POST" class="common-form row g-4 shadow p-4 rounded bg-light">
        @csrf

        <!-- User Name Field -->
        <div class="col-md-6">
            <label for="name" class="form-label fw-bold">User Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" placeholder="Enter User Name" required>
        </div>

        <!-- Email Field -->
        <div class="col-md-6">
            <label for="email" class="form-label fw-bold">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control" placeholder="Enter Email" required>
        </div>

        <!-- Password Field -->
        <div class="col-md-6">
            <label for="password" class="form-label fw-bold">Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" required>
        </div>

        <!-- Confirm Password Field -->
        <div class="col-md-6">
            <label for="password_confirmation" class="form-label fw-bold">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm Password" required>
        </div>

        <!-- Role Selection -->
        <div class="col-md-12">
            <label for="role" class="form-label fw-bold">Assign Role</label>
            <select name="role" id="role" class="form-control" required>
                <option value="" selected disabled>Select a Role</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Submit Button -->
        <div class="col-12 text-center mt-4">
            <button type="submit" class="btn btn-primary px-3" style="background-color: {{ $buttonColor }};">Create User and Assign Role</button>
        </div>

    </form>
</div>

@endsection
