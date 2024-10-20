<!-- resources/views/companies/index.blade.php -->
@extends('layouts.app')

@section('title', 'Companies')

@section('content')
    <div class="container mt-5">
        <h1>Companies</h1>
        <a href="{{ route('companies.create') }}" class="btn btn-primary mb-3">Create New Company</a>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <table id="companies-table" class="table table-striped">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th align="center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($companies as $comp)
                                <tr>
                                    <td>{{ $comp->name }}</td>
                                    <td>
                                        @can('view', $comp)
                                            <a href="{{ route('userDashboard', $comp->slug) }}" class="btn btn-info">View</a>
                                        @endcan

                                        @can('update', $comp)
                                            <a href="{{ route('companies.edit', $comp->slug) }}"
                                               class="btn btn-warning">Edit</a>
                                        @endcan

                                        @can('delete', $comp)
                                            <form action="{{ route('companies.destroy', $comp->slug) }}" method="POST"
                                                  style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"
                                                        onclick="return confirm('Are you sure?')">Delete
                                                </button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#companies-table').DataTable();
        });
    </script>
@endpush
