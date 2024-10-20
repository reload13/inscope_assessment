@extends('layouts.app')

@section('title', 'Create User')

@section('content')
    <div class="container mt-5">

        <h1>Create User</h1>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('users.store', $company->slug) }}" method="POST" id="user-form" data-parsley-validate>
                            @csrf

                            <div class="form-group">
                                <label for="name">Name *</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}"
                                       required data-parsley-maxlength="255" data-parsley-trigger="change">
                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mt-3">
                                <label for="email">Email *</label>
                                <input type="email" name="email" id="email" class="form-control"
                                       value="{{ old('email') }}" required data-parsley-type="email"
                                       data-parsley-trigger="change">
                                @error('email')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mt-3">
                                <label for="password">Password *</label>
                                <input type="password" name="password" id="password" class="form-control" required
                                       data-parsley-minlength="6" data-parsley-trigger="change">
                                @error('password')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mt-3">
                                <label for="role">Role *</label>
                                <select name="role" id="role" class="form-control" required>
                                    <option value="" disabled selected>Select Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->value }}">{{ $role->key }}</option>
                                    @endforeach
                                </select>
                                @error('role')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mt-3">
                                <label for="companies">Select Companies *</label>
                                <select name="company_ids[]" id="companies" class="form-control" multiple required>
                                    @foreach ($companies as $comp)
                                        <option value="{{ $comp->id }}">{{ $comp->name }}</option>
                                    @endforeach
                                </select>
                                @error('companies')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary mt-3">Create User</button>

                            @if($errors->any())
                                <div class="alert alert-danger mt-3">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
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
