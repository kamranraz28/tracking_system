@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')

<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="fa fa-check-circle me-2"></i>
            <strong>Success!</strong> {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-lg p-4">
        <h4 class="mb-4 text-primary"><i class="fa fa-calendar-check me-2"></i> Edit SR Schedule</h4>
        <hr>

        <form method="POST" action="{{ route('scheduleUpdate', $schedule->id) }}" enctype="multipart/form-data" autocomplete="off">
            @csrf

            <!-- SR Selection -->
            <div class="form-group">
                <div class="mb-3">
                    <div class="form-group1">
                        <label for="sr_id">SR:</label>
                        <select name="sr_id" class="form-control" id="sr_id" required>
                            <option>Select SR</option>
                            @foreach($srs as $sr)
                                <option value="{{ $sr->id }}" {{ $schedule->sr_id == $sr->id ? 'selected' : '' }}>
                                    {{ $sr->user->name }} - {{ $sr->user->officeid }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Retail Selection -->
            <div class="form-group">
                <div class="mb-3">
                    <div class="form-group1">
                        <label for="retail_id">Retail:</label>
                        <select name="retail_id" class="form-control" id="retail_id" required>
                            <option>Select Retail</option>
                            @foreach($retails as $retail)
                                <option value="{{ $retail->id }}" {{ $schedule->retail_id == $retail->id ? 'selected' : '' }}>
                                    {{ $retail->user->name }} - {{ $retail->user->officeid }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Date & Time Picker -->
            <div class="form-group">
                <div class="mb-3">
                    <div class="form-group1">
                        <label for="visit_datetime">Visit Date & Time</label>
                        <input type="text" name="visit_datetime" class="form-control datetimepicker" id="visit_datetime"
                            value="{{ old('visit_datetime', $schedule->visit_datetime) }}" required>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="d-grid">
                <button type="submit" class="btn btn-primary fw-bold py-2 shadow-sm" style="background-color: {{ $buttonColor }};">
                    <i class="fas fa-save"></i> Update Schedule
                </button>
            </div>

        </form>
    </div>
</div>

@endsection
