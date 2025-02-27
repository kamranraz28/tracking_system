@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')

    <div class="common-container">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="fa fa-check-circle me-2"></i>
                <strong>Success!</strong> {{ session('success') }}
            </div>
        @endif
        <div class="card p-4">
            <h4 class="mb-4 text-primary"><i class="fa fa-calendar-check me-2"></i> Attendance Monitoring</h4>
            <hr>
           @can('schedule_create')
           <div class="d-flex justify-content-end mb-4">
                <a class="btn btn-primary" href="{{ route('scheduleCreate') }}"
                    style="background-color: {{ $buttonColor }};">
                    <i class="fas fa-plus"></i> Create Schedule
                </a>
            </div>
            @endcan

            <form method="POST" action="{{ route('monitoringSearch') }}" enctype="multipart/form-data"
                autocomplete="off">
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
                        <label for="type">Attendance Type</label>
                        <select name="type" class="form-control" id="type">
                            <option>Select Type</option>
                            <option value="1" {{ session('time') == '1' ? 'selected' : '' }}>All Schedule</option>
                            <option value="2" {{ session('time') == '2' ? 'selected' : '' }}>Missed Visit</option>
                            <option value="3" {{ session('time') == '3' ? 'selected' : '' }}>Upcoming Schedule</option>
                            <option value="4" {{ session('time') == '4' ? 'selected' : '' }}>Late Visit</option>
                            <option value="5" {{ session('time') == '5' ? 'selected' : '' }}>On Time Visit</option>

                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="mb-3">
                        <label for="from_date">From Date:</label>
                        <input type="text" name="from_date" class="form-control date_picker" id="date_picker" placeholder="Select Date">
                    </div>
                </div>

                <div class="form-group">
                    <div class="mb-3">
                        <label for="to_date">To Date:</label>
                        <input type="text" name="to_date" class="form-control date_picker" id="date_picker" placeholder="Select Date">
                    </div>
                </div>

                <!-- Buttons Row -->
                <div class="d-flex justify-content-between">
                    <!-- Track Now Button -->
                    <button type="submit" class="btn btn-primary fw-bold py-2 shadow-sm"
                        style="background-color: {{ $buttonColor }};">
                        <i class="fas fa-upload"></i> Search Now
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
                    <th>Scheduled Visit</th>
                    <th>Attendance Time</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($schedules as $index => $schedule)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $schedule->sr->user->name ?? ''}}</td>
                            <td>{{ $schedule->sr->user->officeid ?? ''}}</td>
                            <td>{{ $schedule->retail->user->name ?? ''}}</td>
                            <td>{{ $schedule->retail->user->officeid ?? ''}}</td>
                            <td>{{ $schedule->visit_datetime ?? ''}}</td>
                            <td>{{ $schedule->attendance->time ?? 'No Attendance' }}</td>
                            <td>
                                <button class="btn
                                @if($status[$index] == 'Absent') btn-danger
                                @elseif($status[$index] == 'On Time') btn-success
                                @elseif($status[$index] == 'Late') btn-warning
                                @elseif($status[$index] == 'Upcoming') btn-info
                                @endif text-white" style="background-color: {{
                    ($status[$index] == 'Missed') ? '#dc3545' :
                    (($status[$index] == 'On Time') ? '#28a745' :
                        (($status[$index] == 'Late') ? '#ffc107' : '')) }};">
                                    {{ $status[$index] }}
                                </button>
                            </td>

                        </tr>
                @endforeach
            </tbody>
        </table>

    </div>

@endsection
