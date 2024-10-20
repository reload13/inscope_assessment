@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Select a Company</h1>

        @if ($companies->isEmpty())
            <p>You do not belong to any companies.</p>
        @else
            <ul>
                @foreach ($companies as $comp)
                    <li>
                        <a href="{{ route('userDashboard', $comp->slug) }}">
                            {{ $comp->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
