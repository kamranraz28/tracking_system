@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')

    <div class="common-container">
        <h4 class="mb-4 text-primary"><i class="fa fa-calendar-check me-2"></i> Field Force Attendance</h4>
        <hr>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="fa fa-check-circle me-2"></i>
                <strong>Success!</strong> {{ session('success') }}
            </div>
        @endif

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
