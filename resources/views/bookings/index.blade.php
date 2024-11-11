@php use Carbon\Carbon; @endphp
@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex">
                        <h4 class="mb-0">{{ __('Bookings') }}</h4>
                        @can('is-admin')
                            <form action="{{ route('bookings.index') }}" method="GET" class="mb-4 ms-auto">
                                <div class="form-group d-flex align-items-center col-auto">
                                    <label for="room_id" class="form-label me-2 mb-0" style="white-space: nowrap;">{{ __('Select Room') }} :</label>
                                    <select name="room_id" id="room_id" class="form-control" onchange="this.form.submit()">
                                        <option value="all" {{ request('room_id') == 'all' ? 'selected' : '' }}>All Rooms</option>
                                        @foreach($rooms as $room)
                                            <option value="{{ $room->id }}" {{ request('room_id') == $room->id ? 'selected' : '' }}>
                                                {{ $room->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>
                        @endcan
                        @can('is-client')
                            <a href="{{ route('bookings.create') }}"
                                class="btn btn-primary btn-sm ms-auto">{{ __('Create') }}</a>
                        @endcan
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    @can('is-admin')
                                        <th class="text-left">{{ __('User Email') }}</th>
                                    @endcan
                                    <th class="text-left">{{ __('Room') }}</th>
                                    <th class="text-left">{{ __('Start') }}</th>
                                    <th class="text-left">{{ __('Finish') }}</th>
                                    <th class="text-left">{{ __('Status') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($bookings as $booking)
                                    <tr>
                                        @can('is-admin')
                                            <td>{{ $booking->user->email }}</td>
                                        @endcan
                                        <td>{{ $booking->room->name }}</td>
                                        <td>{{ Carbon::parse($booking->booking_datetime)->format('d M Y, H:i') }}</td>
                                        <td>{{ Carbon::parse($booking->booking_datetime)->addHour()->format('d M Y, H:i') }}</td>
                                        <td>
                                            @can('is-admin')
                                                <select class="form-control status-select" data-booking-id="{{ $booking->id }}">
                                                    <option value="PENDING" {{ $booking->status == 'PENDING' ? 'selected' : '' }}>
                                                        {{ __('Pending') }}
                                                    </option>
                                                    <option value="ACCEPTED" {{ $booking->status == 'ACCEPTED' ? 'selected' : '' }}>
                                                        {{ __('Accepted') }}
                                                    </option>
                                                    <option value="REJECTED" {{ $booking->status == 'REJECTED' ? 'selected' : '' }}>
                                                        {{ __('Rejected') }}
                                                    </option>
                                                </select>
                                            @else
                                                @switch($booking->status)
                                                    @case('PENDING')
                                                        {{ __('Pending') }}
                                                        @break
                                                    @case('ACCEPTED')
                                                        {{ __('Accepted') }}
                                                        @break
                                                    @case('REJECTED')
                                                        {{ __('Rejected') }}
                                                        @break
                                                    @default
                                                        {{ __('Unknown') }}
                                                @endswitch
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
    </div>
@endsection
