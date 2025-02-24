@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="common-container">
    <h4>List of Retails with Respective Dealers</h4>
    <hr>
    <br>
    <br>


    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>SN</th>
                <th>Retail Name</th>
                <th>Retail ID</th>
                <th>Retail Email</th>
                <th>Retail Phone</th>
                <th>Retail Address</th>
                <th>Dealer Name</th>
                <th>Dealer ID</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($retails as $retail)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $retail->user->name ?? ''}}</td>
                    <td>{{ $retail->user->officeid ?? ''}}</td>
                    <td>{{ $retail->user->email ?? ''}}</td>
                    <td>{{ $retail->user->contact ?? ''}}</td>
                    <td>{{ $retail->user->address ?? ''}}</td>
                    <td>{{ $retail->dealer->user->name ?? ''}}</td>
                    <td>{{ $retail->dealer->user->officeid ?? ''}}</td>
                </tr>

            @endforeach
        </tbody>
    </table>
</div>

@endsection
