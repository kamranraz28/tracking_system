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
            <h4 class="mb-4 text-primary"><i class="fa fa-calendar-check me-2"></i> Track SR</h4>
            <hr>

            <form method="POST" action="{{ route('admin.trackSrStore') }}" enctype="multipart/form-data" autocomplete="off">
                @csrf

                <div class="form-group">
                    <div class="mb-3">
                        <label for="sr_id">SR:</label>
                        <select name="sr_id" class="form-control" id="sr_id">
                            <option value="">Select SR</option>
                            @foreach($srs as $sr)
                                <option value="{{ $sr['id'] }}"
                                    {{ session('sr_id') == $sr['id'] ? 'selected' : '' }}>
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
                            <option value="">Select Duration</option>
                            <option value="1" {{ session('time') == '1' ? 'selected' : '' }}>Today</option>
                            <option value="2" {{ session('time') == '2' ? 'selected' : '' }}>Last Two Days</option>
                            <option value="3" {{ session('time') == '3' ? 'selected' : '' }}>Last 7 Days</option>
                            <option value="4" {{ session('time') == '4' ? 'selected' : '' }}>Last 15 Days</option>
                            <option value="5" {{ session('time') == '5' ? 'selected' : '' }}>Last 30 Days</option>
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

            @if(session('sr_id') && session('time'))
                <!-- See on Map Form (Separate Form) -->
                <form action="{{ route('admin.trackSrMap') }}" method="post" target="_blank" class="mt-3 text-end">
                    @csrf
                    <input type="hidden" name="sr_id" value="{{ session('sr_id') }}">
                    <input type="hidden" name="time" value="{{ session('time') }}">

                    <button type="submit" class="btn btn-primary fw-bold py-2 shadow-sm"
                        style="background-color: {{ $buttonColor }};">
                        <i class="fas fa-map-marked-alt"></i> See on Map
                    </button>
                </form>
            @endif
        </div>

        <br>

        <table id="example" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>SR Name</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($locations as $location)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$location->sr->user['name']}} - {{$location->sr->user['officeid']}}</td>
                        <td>{{$location->lat}}</td>
                        <td>{{$location->lon}}</td>
                        <td>{{$location->created_at}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
