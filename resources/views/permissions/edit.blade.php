@extends('layouts.master')

@section('title', 'Edit Permission')

@section('content')

<div class="container my-5" >
    <!-- Card for better structure -->
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white" style="background-color: {{ $buttonColor }};">
            <h4 class="mb-0">Edit Permission: {{ $permission->name }}</h4>
        </div>
        <div class="card-body">
            <!-- Edit Permission Form -->
            <form action="{{ route('permissions.update', $permission->id) }}" method="POST" class="row g-3">
                @csrf
                @method('PUT') <!-- Method spoofing to handle PUT request -->

                <!-- Permission Name Input -->
                <div class="col-md-12">
                    <label for="name" class="form-label">Permission Name:</label>
                    <input type="text" class="form-control" name="name" id="name" value="{{ $permission->name }}" placeholder="Enter permission name" required>
                </div>

                <!-- Centered button with spacing -->
                <div class="col-12 text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg px-3" style="background-color: {{ $buttonColor }};">Update Permission</button>
                    <a href="{{ route('permissions.index') }}" class="btn btn-secondary btn-lg px-3" style="background-color: {{ $buttonColor }};">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
