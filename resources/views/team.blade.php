@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Team') }}</div>
                    <div class="p-5">
                        @if ($team)
                            <p> Name: {{ $team->name }} </p>
                            <p> Description: {{ $team->description }} </p>
                            <p> Number of users: {{ count($team->users) }} </p>
                        @else
                            <p> N/A </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
