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

        <div class="card shadow-lg p-4">
            <h4 class="mb-4 text-primary"><i class="fa fa-calendar-check me-2"></i> Field Force Schedule</h4>
            <hr>
           @can('schedule_create')
           <div class="d-flex justify-content-end mb-4">
                <a class="btn btn-primary" href="{{ route('scheduleCreate') }}"
                    style="background-color: {{ $buttonColor }};">
                    <i class="fas fa-plus"></i> Create Schedule
                </a>
            </div>
            @endcan

            <form method="POST" action="{{ route('scheduleSearch') }}" enctype="multipart/form-data"
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
                        <label for="time">Time Duration:</label>
                        <select name="time" class="form-control" id="time">
                            <option value="">Select Type</option>
                            <option value="1" {{ session('time') == '1' ? 'selected' : '' }}>Today's Schedules</option>
                            <option value="2" {{ session('time') == '2' ? 'selected' : '' }}>Next 2 Days Schedules</option>
                            <option value="3" {{ session('time') == '3' ? 'selected' : '' }}>Next 7 Days Schedules</option>
                            <option value="4" {{ session('time') == '4' ? 'selected' : '' }}>Next 15 Days Schedules</option>
                            <option value="5" {{ session('time') == '5' ? 'selected' : '' }}>All Schedule</option>

                        </select>
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
                    <th>Retail Address </th>
                    <th>Visit Date & Time</th>
                    <th>Retail on Map</th>
                    @can('schedule_create')
                    <th>Action</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ($schedules as $schedule)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $schedule->sr->user->name ?? ''}}</td>
                        <td>{{ $schedule->sr->user->name ?? ''}}</td>
                        <td>{{ $schedule->retail->user->name ?? ''}}</td>
                        <td>{{ $schedule->retail->user->officeid ?? ''}}</td>
                        <td>{{ $schedule->retail->user->address ?? ''}}</td>
                        <td>{{ $schedule->visit_datetime ?? '' }}</td>
                        <td>
                            <a href="{{ route('retail.mapView', $schedule->retail->id) }}" target="_blank"
                                class="btn btn-sm btn-warning" style="background-color: {{ $buttonColor }};">Map View</a>
                        </td>
                        @can('schedule_create')
                        <td>
                            <!-- Action buttons: Edit and Delete -->
                            <a href="{{ route('scheduleEdit', $schedule->id) }}" class="btn btn-sm btn-warning"
                                style="background-color: {{ $buttonColor }};">Edit</a>

                            <form action="{{ route('scheduleDelete', $schedule->id) }}" method="POST"
                                style="display:inline-block;">
                                @csrf

                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this schedule?')">Delete</button>
                            </form>
                        </td>
                        @endcan


                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

@endsection
