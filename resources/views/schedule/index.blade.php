@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')

    <div class="common-container">
        <h4 class="mb-4 text-primary"><i class="fa fa-calendar-check me-2"></i> SR Schedules</h4>
        <hr>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="fa fa-check-circle me-2"></i>
                <strong>Success!</strong> {{ session('success') }}
            </div>
        @endif


        <div class="d-flex justify-content-end mb-4">
            <a class="btn btn-primary" href="{{ route('sr.scheduleCreate') }}"
                style="background-color: {{ $buttonColor }};">
                <i class="fas fa-plus"></i> Create Schedule
            </a>
        </div>

        <table id="example" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>SN</th>
                    <th>SR Name</th>
                    <th>SR ID</th>
                    <th>Retail Name</th>
                    <th>Retail ID</th>
                    <th>Visit Date & Time</th>
                    <th>Retail on Map</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($schedules as $schedule)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $schedule->sr->user->name ?? ''}}</td>
                        <td>{{ $schedule->sr->user->officeid ?? ''}}</td>
                        <td>{{ $schedule->retail->user->name ?? ''}}</td>
                        <td>{{ $schedule->retail->user->officeid ?? ''}}</td>
                        <td>{{ $schedule->visit_datetime ?? ''}}</td>
                        <td>
                            <a href="{{ route('retail.mapView', $schedule->retail->id) }}" target="_blank" class="btn btn-sm btn-warning"
                                style="background-color: {{ $buttonColor }};">Map View</a>
                        </td>
                        <td>
                            <!-- Action buttons: Edit and Delete -->
                            <a href="{{ route('sr.scheduleEdit', $schedule->id) }}" class="btn btn-sm btn-warning"
                                style="background-color: {{ $buttonColor }};">Edit</a>

                            <form action="{{ route('sr.scheduleDelete', $schedule->id) }}" method="POST"
                                style="display:inline-block;">
                                @csrf

                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this schedule?')">Delete</button>
                            </form>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

@endsection
