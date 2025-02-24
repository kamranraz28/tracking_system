@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="common-container">
    <h4>List of ASMs with Respective RSM</h4>
    <hr>
    <br>
    <br>


    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>SN</th>
                <th>ASM Name</th>
                <th>ASM ID</th>
                <th>ASM Email</th>
                <th>ASM Phone</th>
                <th>ASM Address</th>
                <th>RSM Name</th>
                <th>RSM ID</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($asms as $asm)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $asm->user->name ?? ''}}</td>
                    <td>{{ $asm->user->officeid ?? ''}}</td>
                    <td>{{ $asm->user->email ?? ''}}</td>
                    <td>{{ $asm->user->contact ?? ''}}</td>
                    <td>{{ $asm->user->address ?? ''}}</td>
                    <td>{{ $asm->rsm->name ?? ''}}</td>
                    <td>{{ $asm->rsm->officeid ?? ''}}</td>
                </tr>

            @endforeach
        </tbody>
    </table>
</div>

@endsection
