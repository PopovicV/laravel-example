@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Users') }}</div>
                    @if (count($users) > 0)
                        <table class="table">
                            <tr>
                                <th>No</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Team</th>
                            </tr>
                            @foreach ($users as $index => $user)
                                <tr>
                                    <td> {{ $index + 1 }} </td>
                                    <td> {{ $user->first_name }} {{ ' ' }} {{ $user->last_name }}</td>
                                    <td> {{ $user->email }} </td>
                                    @if ($user->team)
                                        <td> <a href="{{ url('/team/' . $user->team->id) }}">{{ $user->team->name }} </a>
                                        </td>
                                    @else
                                        <td></td>
                                    @endif
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
