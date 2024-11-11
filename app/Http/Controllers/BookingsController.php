<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

class BookingsController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $rooms = [];

        if ($user->role === 'admin') {
            $rooms = Room::all();
            $roomId = $request->input('room_id');
            if ($roomId && $roomId != 'all') {
                $bookings = Booking::where('room_id', $roomId)->get();
            } else {
                $bookings = Booking::all();
            }
        } else {
            $bookings = Booking::where('user_id', $user->id)->get();
        }

        return view('bookings.index', compact('bookings', 'rooms'));
    }

    public function create()
    {
        $rooms = Room::all();
        return view('bookings.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_datetime' => 'required|date|after_or_equal:today',
            'room_id' => 'required|exists:rooms,id',
        ]);

        $room_id = $validated['room_id'];
        $startTime =  Carbon::parse($validated['booking_datetime']);
        $endTime = $startTime->copy()->addHour();

        $conflictingBooking = Booking::where('room_id', $room_id)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->where(function ($q) use ($startTime, $endTime) {
                    $q->where('booking_datetime', '<', $endTime)
                        ->where(DB::raw('DATE_ADD(booking_datetime, INTERVAL 1 HOUR)'), '>', $startTime);
                });
            })
            ->exists();

        if ($conflictingBooking) {
            return redirect()->back()->withErrors(['room_id' => __('This room is already booked for the selected time. Please choose another time or room.')]);
        }

        try {
            $booking = new Booking();
            $booking->user_id = auth()->id();
            $booking->booking_datetime = $validated['booking_datetime'];
            $booking->status = 'PENDING';
            $booking->room_id = $room_id;
            $booking->save();

            return redirect()->route('bookings.index')->with('success', __('Booking successfully created'));
        } catch (Exception) {
            return back()->with('error', __('There was an error processing your booking.'));
        }
    }

    public function update(Request $request, $id)
    {
        $this->isAdminOrAbort();

        try {
            $validator = $request->validate([
                'status' => 'required|in:PENDING,ACCEPTED,REJECTED',
            ]);

            $booking = Booking::find($id);
            if (!$booking) {
                return response()->json([
                    'error' => __('Booking not found.')
                ], 404);
            }

            $booking->status = $validator['status'];
            $booking->save();

            return response()->json([
                'message' => __('Status successfully updated.')
            ]);
        } catch (ValidationException) {
            return response()->json(['error' => __('Validation failed.')], 422);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    private function isAdminOrAbort() {
        if (!Gate::allows('is-admin')) {
            abort(403, __('Access denied.'));
        }
    }
}
