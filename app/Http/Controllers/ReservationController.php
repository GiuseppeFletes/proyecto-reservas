<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\User;
use App\Models\Service;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    // GET /api/reservations
    public function index()
    {
        $this->authorize('viewAny', Reservation::class);

        return response()->json(
            Reservation::with(['user', 'service'])->get(),
            200
        );
    }

    // POST /api/reservations
    public function store(Request $request)
    {
        $this->authorize('create', Reservation::class);

        $validated = $request->validate([
            'user_id'    => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'date'       => 'required|date',
            'time'       => 'required',
            'status'     => 'nullable|in:pending,confirmed,canceled',
            'notes'      => 'nullable|string',
        ]);

        $reservation = Reservation::create($validated);

        return response()->json($reservation, 201);
    }

    // GET /api/reservations/{id}
    public function show(Reservation $reservation)
    {
        $this->authorize('view', $reservation);

        return response()->json(
            $reservation->load(['user', 'service']),
            200
        );
    }

    // PUT /api/reservations/{id}
    public function update(Request $request, Reservation $reservation)
    {
        $this->authorize('update', $reservation);

        $validated = $request->validate([
            'date'       => 'sometimes|date',
            'time'       => 'sometimes',
            'status'     => 'sometimes|in:pending,confirmed,canceled',
            'notes'      => 'nullable|string',
        ]);

        $reservation->update($validated);

        return response()->json($reservation, 200);
    }

    // DELETE /api/reservations/{id}
    public function destroy(Reservation $reservation)
    {
        $this->authorize('delete', $reservation);
        $reservation->delete();
        return response()->json(null, 204);
    }
}
