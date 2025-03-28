@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="fa fa-check-circle me-2"></i>
            <strong>Success!</strong> {{ session('success') }}
        </div>
    @endif

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-body p-4">
                        <h2 class="text-center mb-4 fw-bold text-primary">Bulk Upload</h2>

                        <form action="{{ route('admin.csvUpload') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- File Upload Field -->
                            <div class="mb-3">
                                <label for="csv_file" class="form-label fw-bold">Upload CSV File</label>
                                <input type="file" class="form-control shadow-sm" name="csv_file" id="csv_file"
                                    accept=".csv" required>
                            </div>

                            <div class="form-group">
                                <div class="mb-3">
                                    <div class="form-group1">
                                        <label for="type">Select Upload Type :</label>
                                        <select name="type" class="form-control" id="type" required="required">
                                            <option>Select Type</option>
                                            <option value="1">Regional Sales Manager(RSM)</option>
                                            <option value="2">Area Sales Manager(ASM)</option>
                                            <option value="3">Teritory Sales Manager(TSM)</option>
                                            <option value="4">Local Dealer(LD)</option>
                                            <option value="5">Retail</option>
                                            <option value="6">Sales Representative (SR)</option>
                                            <option value="7">SR-Retail Visit Schedule</option>
                                            <option value="8">Retail Location</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary fw-bold py-2 shadow-sm"
                                    style="background-color: {{ $buttonColor }};">
                                    <i class="fas fa-upload"></i> Upload File
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
