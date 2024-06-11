<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AppointmentController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $status = $request->status;
        $users = Appointment::query()->with('client')
            ->when(!is_null($request->status), function ($q) use ($status) {
                $q->where('status', $status);
            })
            ->paginate(10)
            ->through(fn($appointment) => [
                'id' => $appointment->id,
                'start_time' => $appointment->start_time->format('Y-m-d h:i A'),
                'end_time' => $appointment->end_time->format('Y-m-d h:i A'),
                'status' => [
                    'name' => Str::lower($appointment->status->name),
                    'color' => $appointment->status->color(),
                ],
                'client' => $appointment->client
            ]);
        return response()->json([
            'message' => "Appointment Lists Successfully!",
            'data' => $users,
        ]);
    }
}
