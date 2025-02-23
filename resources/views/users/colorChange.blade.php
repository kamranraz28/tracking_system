@extends('layouts.master')

@section('title', 'My Profile')

@section('content')

<div class="common-container container mt-4">
    <h2 class="text-center mb-4">Change Application Color</h2>

    @if (session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('updateColors') }}" method="POST" class="common-form row g-4 shadow p-4 rounded bg-white"
        enctype="multipart/form-data">
        @csrf

        <!-- Header Background Color -->
        <div class="col-md-6">
            <label for="headerColor" class="form-label">Header Background Color</label>
            <input type="color" id="headerColor" name="headerColor" class="form-control form-control-color"
                value="{{ old('headerColor', $headerColor ?? '#ffffff') }}">
        </div>

        <!-- Sidebar Background Color -->
        <div class="col-md-6">
            <label for="sidebarColor" class="form-label">Sidebar Background Color</label>
            <input type="color" id="sidebarColor" name="sidebarColor" class="form-control form-control-color"
                value="{{ old('sidebarColor', $sidebarColor ?? '#ffffff') }}">
        </div>

        <!-- Button Background Color -->
        <div class="col-md-6 mt-4">
            <label for="buttonColor" class="form-label">Button Background Color</label>
            <input type="color" id="buttonColor" name="buttonColor" class="form-control form-control-color"
                value="{{ old('buttonColor', $buttonColor ?? '#ffffff') }}">
        </div>

        <!-- Submit Button -->
        <div class="col-12 text-center mt-4">
            <button type="submit" class="btn btn-primary px-3" style="background-color: {{ $buttonColor }};">Update </button>
        </div>
    </form>
</div>

@endsection
