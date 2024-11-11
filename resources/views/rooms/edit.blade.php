@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2 class="mb-0">{{ __('Edit Room') }}</h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ isset($room) ? route('rooms.update', $room->id) : route('rooms.store') }}">
                            @csrf
                            @if (isset($room))
                                @method('PUT')
                            @endif

                            <div class="mb-4">
                                <label for="name" class="form-label">{{ __('Room Name') }}</label>
                                <input id="name" name="name" type="text" value="{{ old('name', $room->name ?? '') }}" class="form-control" required>
                            </div>

                            <div class="mb-4">
                                <label for="description" class="form-label">{{ __('Room Description') }}</label>
                                <input id="description" name="description" type="text" value="{{ old('description', $room->description ?? '') }}" class="form-control">
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('rooms.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                                <button type="submit" class="btn btn-primary">{{ isset($room) ? __('Update Room') : __('Create Room') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
