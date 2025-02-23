@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')

<div class="container my-5">
    <!-- Card for better structure -->
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Create Permission</h4>
        </div>
        <div class="card-body">
            <!-- Form for creating a permission -->
            <form action="{{ route('permissions.store') }}" method="POST" class="row g-3">
                @csrf
                <div class="col-md-12">
                    <label for="name" class="form-label">Permission Name:</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter permission name" required>
                </div>

                <!-- Centered button with spacing -->
                <div class="col-12 text-center mt-4">
                    <button type="submit" class="btn btn-primary px-3" style="background-color: {{ $buttonColor }};">Create Permission</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
