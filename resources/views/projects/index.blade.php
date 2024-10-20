@extends('layouts.app')

@section('title', 'Projects')

@section('content')
    <div class="container mt-5">
        <h1>Projects</h1>

        @can('create', [new \App\Models\Project, $company])
            <a href="{{ route('projects.create', $company->slug) }}" class="btn btn-primary mb-3">Create New Project</a>
        @endcan
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <table id="projects-table" class="table table-striped">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Company</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($projects as $project)
                                <tr>
                                    <td>{{ $project->name }}</td>
                                    <td>{{ $project->description }}</td>
                                    <td>{{ $project->company->name }}</td>
                                    <td align="right">
                                        @can('view', [$project, $company])
                                            <a href="{{ route('projects.show',[$company->slug, $project->id]) }}"
                                               class="btn btn-info mr-2">View</a>
                                        @endcan

                                        @can('update', [$project, $company])
                                            <a href="{{ route('projects.edit', [$company->slug, $project->id]) }}"
                                               class="btn btn-warning mr-2">Edit</a>
                                        @endcan

                                        @can('delete', [$project, $company])
                                            <form
                                                action="{{ route('projects.destroy', [$company->slug, $project->id]) }}"
                                                method="POST" style="display:inline;">
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
            $('#projects-table').DataTable();
        });
    </script>
@endpush
