@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="common-container">
    <h4>List of Regional Sales Manager (RSM)</h4>
    <hr>
    <br>
    <br>


    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>SN</th>
                <th>RSM Name</th>
                <th>RSM ID</th>
                <th>RSM Email</th>
                <th>RSM Phone</th>
                <th>RSM Address</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($rsms as $rsm)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $rsm->name ?? ''}}</td>
                    <td>{{ $rsm->officeid ?? ''}}</td>
                    <td>{{ $rsm->email ?? ''}}</td>
                    <td>{{ $rsm->contact ?? ''}}</td>
                    <td>{{ $rsm->address ?? ''}}</td>
                </tr>

            @endforeach
        </tbody>
    </table>
</div>

@endsection
