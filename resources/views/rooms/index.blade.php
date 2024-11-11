@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex">
                        <h4 class="mb-0">{{ __('Rooms') }}</h4>
                        <a href="{{ route('rooms.create') }}" class="btn btn-primary btn-sm ms-auto">{{ __('Create') }}</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th class="text-left">{{ __('Name') }}</th>
                                    <th class="text-left">{{ __('Description') }}</th>
                                    <th class="text-left">{{ __('Actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($rooms as $room)
                                    <tr>
                                        <td>{{ $room->name }}</td>
                                        <td>{{ $room->description }}</td>
                                        <td class="d-flex">
                                            <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-primary btn-sm me-2">{{ __('Edit') }}</a>
                                            <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure?') }}');" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    {{ __('Delete') }}
                                                </button>
                                            </form>
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
