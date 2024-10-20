@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
    <div class="container mt-5">
        <h1>Edit User: {{ $user->name }}</h1>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('users.update', [$company->slug, $user->id]) }}" method="POST"
                              id="user-form" data-parsley-validate>
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control"
                                       value="{{ old('name', $user->name) }}"
                                       data-parsley-maxlength="255" data-parsley-trigger="change">
                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mt-3">
                                <label for="email">Email *</label>
                                <input type="email" name="email" id="email" class="form-control"
                                       value="{{ old('email', $user->email) }}" required
                                       data-parsley-type="email" data-parsley-trigger="change">
                                @error('email')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mt-3">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control"
                                       data-parsley-minlength="6" data-parsley-trigger="change">
                                @error('password')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mt-3">
                                <label for="role">Role</label>
                                <select name="role" id="role" class="form-control" required>
                                    @foreach ($roles as $role)
                                        <option
                                            value="{{ $role->value }}" {{ $user->roles->first()->name == $role->value ? 'selected' : '' }}>
                                            {{ $role->key }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mt-3">
                                <label for="companies">Select Companies</label>
                                <select name="company_ids[]" id="companies" class="form-control" multiple >
                                    @foreach ($companies as $comp)
                                        <option {{ $user->companies->contains($comp->id) ? 'selected' : '' }} value="{{ $comp->id }}">{{ $comp->name }}</option>
                                    @endforeach
                                </select>
                                @error('companies')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary mt-3">Update User</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#user-form').parsley();
        });
    </script>
@endpush
