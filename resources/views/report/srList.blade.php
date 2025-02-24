@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="common-container">
    <h4>List of SRs with Respective Dealers</h4>
    <hr>
    <br>
    <br>


    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>SN</th>
                <th>SR Name</th>
                <th>SR ID</th>
                <th>SR Email</th>
                <th>SR Phone</th>
                <th>SR Address</th>
                <th>Dealer Name</th>
                <th>Dealer ID</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($srs as $sr)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $sr->user->name ?? ''}}</td>
                    <td>{{ $sr->user->officeid ?? ''}}</td>
                    <td>{{ $sr->user->email ?? ''}}</td>
                    <td>{{ $sr->user->contact ?? ''}}</td>
                    <td>{{ $sr->user->address ?? ''}}</td>
                    <td>{{ $sr->dealer->user->name ?? ''}}</td>
                    <td>{{ $sr->dealer->user->officeid ?? ''}}</td>
                </tr>

            @endforeach
        </tbody>
    </table>
</div>

@endsection
