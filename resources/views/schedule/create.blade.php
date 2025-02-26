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
            <h4 class="mb-4 text-primary"><i class="fa fa-calendar-check me-2"></i> Create SR Schedule</h4>
            <hr>

            <form method="POST" action="{{ route('scheduleStore') }}" enctype="multipart/form-data" autocomplete="off">
                @csrf

                <div class="form-group">
                    <div class="mb-3">
                        <div class="form-group1">
                            <label for="sr_id">SR:</label>
                            <select name="sr_id" class="form-control" id="sr_id" required="required">
                                <option>Select SR</option>
                                @foreach($srs as $sr)
                                    <option value="{{ $sr['id'] }}">
                                        {{ $sr->user['name'] }} - {{ $sr->user['officeid'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="mb-3">
                        <div class="form-group1">
                            <label for="retail_id">Retail:</label>
                            <select name="retail_id" class="form-control" id="retail_id" required="required">
                                <option>Select Retail</option>
                                @foreach($retails as $retail)
                                    <option value="{{ $retail['id'] }}">
                                        {{ $retail->user['name'] }} - {{ $retail->user['officeid'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <div class="mb-3">
                        <div class="form-group1">
                            <label for="visit_datetime">Visit Date & Time</label>
                            <input type="text" name="visit_datetime" class="form-control" id="visit_datetime"
                                placeholder="Choose Date and Time" required="required">
                        </div>
                    </div>
                </div>


                <!-- Submit Button -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary fw-bold py-2 shadow-sm"
                        style="background-color: {{ $buttonColor }};">
                        <i class="fas fa-upload"></i> Create Schedule
                    </button>
                </div>


            </form>
        </div>
    </div>

@endsection
