@extends('layouts.app')

@section('title', 'Edit Company')

@section('content')
    <div class="container mt-5">
        <h1>Edit Company: {{ $company->name }}</h1>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('companies.update', $company->slug) }}" method="POST" id="company-form"
                              data-parsley-validate>
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="name">Company Name</label>
                                <input type="text" name="name" id="name" class="form-control"
                                       value="{{ old('name', $company->name) }}" data-parsley-maxlength="255"
                                       data-parsley-trigger="change">
                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mt-3">
                                <label for="slug">Company slug *</label>
                                <input type="text" name="slug" id="slug" class="form-control"
                                       value="{{ old('slug', $company->slug) }}" required data-parsley-type="slug"
                                       data-parsley-trigger="change">
                                @error('slug')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary mt-3">Update Company</button>
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
            $('#company-form').parsley();
        });
    </script>
@endpush
