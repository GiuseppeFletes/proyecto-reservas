<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    // GET /api/services
    public function index()
    {
        return response()->json(Service::all(), 200);
    }

    // POST /api/services
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration'    => 'required|integer',
            'price'       => 'nullable|numeric',
        ]);

        $service = Service::create($validated);

        return response()->json($service, 201);
    }

    // GET /api/services/{id}
    public function show(Service $service)
    {
        return response()->json($service, 200);
    }

    // PUT /api/services/{id}
    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name'        => 'sometimes|string|max:255',
            'description' => 'sometimes|nullable|string',
            'duration'    => 'sometimes|integer',
            'price'       => 'sometimes|nullable|numeric',
        ]);

        $service->update($validated);

        return response()->json($service, 200);
    }

    // DELETE /api/services/{id}
    public function destroy(Service $service)
    {
        $service->delete();
        return response()->json(null, 204);
    }
}
