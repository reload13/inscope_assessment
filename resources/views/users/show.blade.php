@extends('layouts.app')

@section('title', 'User Details')

@section('content')
    <div class="container mt-5">
        <h1>User Details: {{ $user->name }}</h1>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">User Information</h5>
                                <p><strong>Name:</strong> {{ $user->name }}</p>
                                <p><strong>Email:</strong> {{ $user->email }}</p>
                                <p><strong>Roles:</strong> {{ implode(', ', $user->getRoleNames()->toArray()) }}</p>
                                <p><strong>Created At:</strong> {{ $user->created_at->format('Y-m-d') }}</p>
                                <p><strong>Updated At:</strong> {{ $user->updated_at->format('Y-m-d') }}</p>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('users.index', $company->slug) }}" class="btn btn-secondary">Back to
                                Users</a>

                            <div>
                                @can('update', $company)
                                    <a href="{{ route('users.edit', [$company->slug, $user->id]) }}"
                                       class="btn btn-warning">Edit</a>
                                @endcan

                                @can('delete', $company)
                                    <form action="{{ route('users.destroy', [$company->slug, $user->id]) }}"
                                          method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Are you sure?')">Delete
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
