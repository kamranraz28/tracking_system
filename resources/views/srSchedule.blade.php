@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')

<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="fa fa-check-circle me-2"></i>
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(count($errors))
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="fa fa-exclamation-circle me-2"></i>
            <strong>Whoops!</strong> There were some problems with your input.
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-lg p-4">
        <h4 class="mb-4 text-primary"><i class="fa fa-calendar-check me-2"></i> SR Schedules</h4>
        <hr>

        <form method="POST" action="{{ route('distributor.srScheduleStore') }}" enctype="multipart/form-data" autocomplete="off">
            @csrf

            <div class="row g-3">
                <!-- Select SR -->
                <div class="col-md-6">
                    <label for="sr" class="form-label fw-bold">Select SR:</label>
                    <select name="sr_id" id="sr" class="form-select" required>
                        <option value="">Select SR</option>
                        @foreach($srs as $sr)
                            <option value="{{ $sr['sr_id'] }}">
                                {{ $sr->srs['firstname'] }} - {{$sr->srs['officeid']}}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Select Retailer -->
                <div class="col-md-6">
                    <label for="retailer" class="form-label fw-bold">Select Retailer:</label>
                    <select name="retailer_id" id="retailer" class="form-select" required>
                        <option value="">Select Retailer</option>
                        @foreach($retailers as $retailer)
                            <option value="{{ $retailer['retailer_id'] }}">
                                {{ $retailer['name'] }} - {{$retailer['officeid']}}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Visit Date -->
                <div class="col-md-6">
                    <label for="datepicker3" class="form-label fw-bold">Visit Date:</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                        <input type="text" name="visit_date" class="form-control" id="datepicker3" placeholder="YYYY-MM-DD" autocomplete="off">
                    </div>
                </div>
            </div>

            <div class="text-end mt-4">
                <button type="submit" class="btn btn-primary px-4 rounded-pill">
                    <i class="fa fa-paper-plane me-1"></i> Submit
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
