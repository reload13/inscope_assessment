@extends('layouts.app')

@section('title', 'Edit Project')

@section('content')
    <div class="container mt-5">
        <h1>Edit Project: {{ $project->name }}</h1>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('projects.update', [$company->slug,$project->id]) }}" method="POST"
                              id="project-form" data-parsley-validate>
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="name">Project Name *</label>
                                <input type="text" name="name" id="name" class="form-control"
                                       value="{{ old('name', $project->name) }}" required data-parsley-maxlength="255"
                                       data-parsley-trigger="change">
                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mt-3">
                                <label for="description">Project Description *</label>
                                <textarea name="description" id="description" class="form-control" required
                                          data-parsley-maxlength="500"
                                          data-parsley-trigger="change">{{ old('description', $project->description) }}</textarea>
                                @error('description')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            {{--        <div class="form-group">--}}
                            {{--            <label for="company_id">Select Company</label>--}}
                            {{--            <select name="company_id" id="company_id" class="form-control" required>--}}
                            {{--                @foreach ($companies as $company)--}}
                            {{--                    <option value="{{ $company->id }}" {{ old('company_id', $project->company_id) == $company->id ? 'selected' : '' }}>--}}
                            {{--                        {{ $company->name }}--}}
                            {{--                    </option>--}}
                            {{--                @endforeach--}}
                            {{--            </select>--}}
                            {{--            @error('company_id')--}}
                            {{--            <div class="text-danger">{{ $message }}</div>--}}
                            {{--            @enderror--}}
                            {{--        </div>--}}

                            <button type="submit" class="btn btn-primary mt-3">Update Project</button>
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
            $('#project-form').parsley();
        });
    </script>
@endpush
