@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')

    <div class="common-container">


        <div class="card shadow-lg p-4">
            <h4 class="mb-4 text-primary"><i class="fa fa-calendar-check me-2"></i> Field Force Attendance</h4>
            <hr>
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                    <i class="fa fa-check-circle me-2"></i>
                    <strong>Success!</strong> {{ session('success') }}
                </div>
            @endif


            <form method="POST" action="{{ route('fieldForceAttendanceStore') }}" enctype="multipart/form-data" autocomplete="off">
                @csrf

                <div class="form-group">
                    <div class="mb-3">
                        <label for="sr_id">Field Force:</label>
                        <select name="sr_id" class="form-control" id="sr_id">
                            <option value="">Select Field Force</option>
                            @foreach($srs as $sr)
                                <option value="{{ $sr['id'] }}" {{ session('sr_id') == $sr['id'] ? 'selected' : '' }}>
                                    {{ $sr->user['name'] }} - {{ $sr->user['officeid'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="mb-3">
                        <div class="form-group1">
                            <label for="from_date">From Date:</label>
                            <input type="text" name="from_date" class="form-control" id="date_picker"
                                placeholder="Select Date">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="mb-3">
                        <div class="form-group1">
                            <label for="to_date">To Date:</label>
                            <input type="text" name="to_date" class="form-control" id="date_picker"
                                placeholder="Select Date">
                        </div>
                    </div>
                </div>

                <!-- Buttons Row -->
                <div class="d-flex justify-content-between">
                    <!-- Track Now Button -->
                    <button type="submit" class="btn btn-primary fw-bold py-2 shadow-sm"
                        style="background-color: {{ $buttonColor }};">
                        <i class="fas fa-upload"></i> Track Now
                    </button>
                </div>
            </form>
        </div>
        <br>

        <table id="example" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>SN</th>
                    <th>Field Force Name</th>
                    <th>Field Force ID</th>
                    <th>Retail Name</th>
                    <th>Retail ID</th>
                    <th>Attendance Time</th>
                    <th>Attendance Image</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($attendances as $attendance)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $attendance->sr->user->name ?? ''}}</td>
                        <td>{{ $attendance->sr->user->officeid ?? ''}}</td>
                        <td>{{ $attendance->retail->user->name ?? ''}}</td>
                        <td>{{ $attendance->retail->user->officeid ?? ''}}</td>
                        <td>{{ $attendance->time ?? ''}}</td>
                        <td>
                            <img src="{{ asset('uploads/' . $attendance->image) }}" alt="Attendance Image" width="50">
                        </td>


                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

@endsection
