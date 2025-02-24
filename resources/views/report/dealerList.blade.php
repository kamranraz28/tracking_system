@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="common-container">
    <h4>List of Local Dealers with Respective TSM</h4>
    <hr>
    <br>
    <br>


    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>SN</th>
                <th>Dealer Name</th>
                <th>Dealer ID</th>
                <th>Dealer Email</th>
                <th>Dealer Phone</th>
                <th>Dealer Address</th>
                <th>TSM Name</th>
                <th>TSM ID</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($dealers as $dealer)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $dealer->user->name ?? ''}}</td>
                    <td>{{ $dealer->user->officeid ?? ''}}</td>
                    <td>{{ $dealer->user->email ?? ''}}</td>
                    <td>{{ $dealer->user->contact ?? ''}}</td>
                    <td>{{ $dealer->user->address ?? ''}}</td>
                    <td>{{ $dealer->tsm->user->name ?? ''}}</td>
                    <td>{{ $dealer->tsm->user->officeid ?? ''}}</td>
                </tr>

            @endforeach
        </tbody>
    </table>
</div>

@endsection
