@extends('layouts.master')

@section('title', 'My Profile')

@section('content')

<div class="common-container container mt-4">

    <h2 class="text-center mb-4">Change Application Logo</h2>

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

    <form action="{{ route('updateLogo') }}" method="POST"
        class="common-form row g-4 shadow p-4 rounded bg-light" enctype="multipart/form-data">
        @csrf


        <!-- Image Upload Field -->
        <div class="col-md-6">
            <label for="image" class="form-label fw-bold">Upload New Logo</label>
            <input type="file" name="image" id="image" class="form-control" accept="image/*">
            <small class="form-text text-muted">Leave blank if you don't want to change/upload the image.</small>
        </div>


        <!-- Submit Button -->
        <div class="col-12 text-center mt-4">
            <button type="submit" class="btn btn-primary px-3" style="background-color: {{ $buttonColor }};">Update Logo</button>
        </div>
    </form>
</div>

@endsection