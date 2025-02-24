@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="common-container">
    <h4>List of TSMs with Respective ASM</h4>
    <hr>
    <br>
    <br>


    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>SN</th>
                <th>TSM Name</th>
                <th>TSM ID</th>
                <th>TSM Email</th>
                <th>TSM Phone</th>
                <th>TSM Address</th>
                <th>ASM Name</th>
                <th>ASM ID</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($tsms as $tsm)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $tsm->user->name ?? ''}}</td>
                    <td>{{ $tsm->user->officeid ?? ''}}</td>
                    <td>{{ $tsm->user->email ?? ''}}</td>
                    <td>{{ $tsm->user->contact ?? ''}}</td>
                    <td>{{ $tsm->user->address ?? ''}}</td>
                    <td>{{ $tsm->asm->user->name ?? ''}}</td>
                    <td>{{ $tsm->asm->user->officeid ?? ''}}</td>
                </tr>

            @endforeach
        </tbody>
    </table>
</div>

@endsection
