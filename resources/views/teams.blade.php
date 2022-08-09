@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Teams') }}</div>
                    @if (count($teams) > 0)
                        <table class="table">
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Number of users</th>
                            </tr>
                            @foreach ($teams as $index => $team)
                                <tr>
                                    <td> {{ $index + 1 }} </td>
                                    <td> <a href="{{ url('/team/' . $team->id) }}">{{ $team->name }} </a> </td>
                                    <td> {{ $team->description }} </td>
                                    <td> {{ count($team->users) }} </td>
                                </tr>
                            @endforeach
                        </table>
                    @else
                        <p> empty </p>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
