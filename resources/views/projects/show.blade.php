@extends('layouts.app')

@section('title', 'Project Details')

@section('content')
    <div class="container mt-5">
        <h1>Project Details: {{ $project->name }}</h1>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Project Information</h5>
                                <p><strong>Project Name:</strong> {{ $project->name }}</p>
                                <p><strong>Description:</strong> {{ $project->description }}</p>
                                <p><strong>Company:</strong> {{ $project->company->name }}</p>
                                <p><strong>Created By:</strong> {{ $project->creator->name }}</p>
                                <p><strong>Created At:</strong> {{ $project->created_at->format('Y-m-d') }}</p>
                                <p><strong>Updated At:</strong> {{ $project->updated_at->format('Y-m-d') }}</p>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('projects.index',$company->slug) }}" class="btn btn-secondary">Back to
                                Projects</a>

                            <div>
                                @can('update', [$project, $company])
                                    <a href="{{ route('projects.edit', [$company->slug, $project->id]) }}"
                                       class="btn btn-warning">Edit</a>
                                @endcan

                                @can('delete', [$project, $company])
                                    <form action="{{ route('projects.destroy', [$company->slug, $project->id]) }}"
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
