@extends('layouts.master')

@section('title', 'Create Role')

@section('content')

<div class="common-container container mt-4 p-4 bg-light shadow rounded">

    <h2 class="text-center mb-4">Create Role</h2>

    <!-- Success and Error Messages -->
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

    <!-- Create Role Form -->
    <form action="{{ route('roles.store') }}" method="POST" class="common-form row g-4">
        @csrf

        <!-- Role Name Input -->
        <div class="col-md-6 offset-md-3">
            <label for="name" class="form-label fw-bold">Role Name:</label>
            <input type="text" name="name" id="name" class="form-control" required placeholder="Enter role name">
        </div>

        <!-- Permissions Table -->
        <div class="col-md-12 mt-4">
            <label class="form-label fw-bold">Assign Permissions:</label>
            <div class="table-responsive">
                <table id="example" class="display" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">SN</th>
                            <th>Permission Name</th>
                            <th class="text-center">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="select-all">
                                    <label class="form-check-label fw-bold" for="select-all">Select All</label>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permissions as $index => $permission)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $permission->name }}</td>
                            <td class="text-center">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input permission-checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission-{{ $permission->id }}">
                                    <label class="form-check-label" for="permission-{{ $permission->id }}"></label>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="col-12 text-center mt-4">
            <button type="submit" class="btn btn-primary" style="background-color: {{ $buttonColor }};">Create Role</button>
        </div>
    </form>
</div>

<!-- JavaScript for Select All functionality -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectAllCheckbox = document.getElementById('select-all');
        const permissionCheckboxes = document.querySelectorAll('.permission-checkbox');

        selectAllCheckbox.addEventListener('change', function () {
            permissionCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
        });

        // Ensure "Select All" gets unchecked if any individual permission is unchecked
        permissionCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                if (!this.checked) {
                    selectAllCheckbox.checked = false;
                } else {
                    // If all checkboxes are checked, "Select All" should also be checked
                    if ([...permissionCheckboxes].every(chk => chk.checked)) {
                        selectAllCheckbox.checked = true;
                    }
                }
            });
        });
    });
</script>

@endsection
