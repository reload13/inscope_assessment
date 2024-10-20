@extends('layouts.app')

@section('title', 'Create Project')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4">Create Project</h1>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('projects.store', $company->slug) }}" method="POST" id="project-form" data-parsley-validate>
                            @csrf
                            <div class="form-group mb-3">
                                <label for="name">Project Name *</label>
                                <input
                                    type="text"
                                    name="name"
                                    id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}"
                                    required
                                    data-parsley-maxlength="255"
                                    data-parsley-trigger="change"
                                >
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="description">Project Description *</label>
                                <textarea
                                    name="description"
                                    id="description"
                                    class="form-control @error('description') is-invalid @enderror"
                                    required
                                    data-parsley-maxlength="500"
                                    data-parsley-trigger="change"
                                >{{ old('description') }}</textarea>
                                @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Create Project</button>
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
        $(document).ready(function() {
            $('#project-form').parsley();
        });
    </script>
@endpush
