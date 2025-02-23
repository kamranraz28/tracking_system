@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')


<div class="container mt-2">
    <h2 class="text-center mb-4">Permissions</h2>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

    <div class="d-flex justify-content-end mb-4">
        <a class="btn btn-primary" href="{{ route('permissions.create') }}" style="background-color: {{ $buttonColor }};">
            <i class="fas fa-plus"></i> Create Permission
        </a>
    </div>




    <div class="table-responsive">
        <table id="example" class="display" style="width:100%">

            <thead>
                <tr>
                    <th>SN</th>
                    <th>Permission Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($permissions as $permission)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $permission->name }}</td>
                        <td>
                            <!-- Edit Button -->
                            <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-warning btn-sm" style="background-color: {{ $buttonColor }};">
                                <i class="fas fa-edit"></i> Edit
                            </a>

                            <!-- Delete Button -->
                            <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this permission?');">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


@endsection
