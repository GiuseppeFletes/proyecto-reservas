<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\User;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


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

    // Validación base (aplica a ambos roles)
    $validated = $request->validate([
        'service_id' => 'required|exists:services,id',
        'date'       => 'required|date',
        'time'       => 'required',
        'status'     => 'nullable|in:pending,confirmed,canceled',
        'notes'      => 'nullable|string',
    ]);

    // Si es ADMIN → debe enviar user_id manualmente
    if (auth()->user()->role === 'admin') {

        $validator = \Validator::make($request->all(), [
        'user_id' => 'required|exists:users,id'
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    $validated['user_id'] = $request->user_id;

    } else {
        // Si es CLIENTE → Laravel asigna automáticamente el user_id
        $validated['user_id'] = auth()->id();
    }
    //verificar disponibilidad de horario
    $alreadyExistis = Reservation::where('service_id', $validated['service_id'])
        ->where('date', $validated['date'])
        ->where('time', $validated['time'])
        ->where('status', '!=', 'canceled')
        ->exists();
    if($alreadyExistis){
        return response()->json([
            'message' => 'Este horario ya esta reservado para este servicio'
        ], 409);
    }    
    // Crear reserva
    $reservation = Reservation::create($validated);

    return response()->json([
        'message' => 'Reserva creada correctamente',
        'data' => $reservation
    ], 201);
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
