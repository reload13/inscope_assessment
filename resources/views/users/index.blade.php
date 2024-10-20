@extends('layouts.app')

@section('title', 'Users')

@section('content')
    <div class="container mt-5">
        <h1>Users</h1>
        @can('create', App\Models\User::class)
            <a href="{{ route('users.create', $company->slug) }}" class="btn btn-primary mb-3">Create New User</a>
        @endcan
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <table id="users-table" class="table table-striped">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Roles</th>
                                <th>Companies</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ implode(', ', $user->getRoleNames()->toArray()) }}</td>
                                    <td>{{ implode(', ', $user->companies->pluck('name')->toArray()) }}</td>
                                    <td>
                                        @can('view', [$user, $company])
                                            <a href="{{ route('users.show', [$company->slug, $user->id]) }}" class="btn btn-info">View</a>
                                        @endcan

                                        @can('update', $company)
                                            <a href="{{ route('users.edit', [$company->slug, $user->id]) }}"
                                               class="btn btn-warning">Edit</a>
                                        @endcan

                                        @can('delete', $company)
                                            <form action="{{ route('users.destroy', [$company->slug, $user->id]) }}" method="POST"
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
            $('#users-table').DataTable(); // Initialize DataTables
        });
    </script>
@endpush
