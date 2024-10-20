@extends('layouts.app')

@section('title', 'Company Details')

@section('content')
    <div class="container mt-5">
        <h1>Company Details: {{ $company->name }}</h1>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Company Information</h5>
                                <p><strong>Company Name:</strong> {{ $company->name }}</p>
                                <p><strong>Created At:</strong> {{ $company->created_at->format('Y-m-d') }}</p>
                                <p><strong>Updated At:</strong> {{ $company->updated_at->format('Y-m-d') }}</p>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('companies.index') }}" class="btn btn-secondary">Back to Companies</a>

                            <div>
                                @can('update', $company)
                                    <a href="{{ route('companies.edit', $company->id) }}"
                                       class="btn btn-warning">Edit</a>
                                @endcan

                                @can('delete', $company)
                                    <form action="{{ route('companies.destroy', $company->id) }}" method="POST"
                                          style="display:inline;">
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
