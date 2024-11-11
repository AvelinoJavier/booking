@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2 class="mb-0">{{ __('Edit Booking') }}</h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('bookings.store') }}">
                            @csrf

                            <div class="mb-4">
                                <label for="booking_datetime" class="form-label">{{ __('Booking DateTime') }}</label>
                                <input id="booking_datetime" name="booking_datetime" type="datetime-local" class="form-control" required>
                            </div>

                            <div class="mb-4">
                                @if ($errors->has('room_id'))
                                    <div class="alert alert-danger">
                                        {{ $errors->first('room_id') }}
                                    </div>
                                @endif
                                <label for="room_id" class="form-label">{{ __('Room') }}</label>
                                <select id="room_id" name="room_id" class="form-control" required>
                                    <option value="" disabled selected>{{ __('Select a room') }}</option>
                                    @foreach ($rooms as $room)
                                        <option value="{{ $room->id }}">{{ $room->name }} - {{ $room->description }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('bookings.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                                <button type="submit" class="btn btn-primary">{{ __('Create Booking') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
