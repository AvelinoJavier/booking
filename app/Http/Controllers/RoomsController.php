<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RoomsController extends Controller
{
    public function __construct()
    {
        $this->isAdminOrAbort();
    }

    public function index()
    {
        $rooms = Room::all();
        return view('rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('rooms.edit');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'string|max:255',
        ]);

        Room::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
        ]);

        return redirect()->route('rooms.index')->with('success', __('Room created successfully'));
    }

    public function edit(Room $room)
    {
        return view('rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'string|max:255',
        ]);

        $room->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
        ]);

        return redirect()->route('rooms.index')->with('success', __('Room updated successfully'));
    }

    public function destroy(Room $room)
    {
        $room->delete();

        return redirect()->route('rooms.index')->with('success', __('Room deleted successfully'));
    }

    private function isAdminOrAbort() {
        if (!Gate::allows('is-admin')) {
            abort(403, __('Access denied.'));
        }
    }
}
