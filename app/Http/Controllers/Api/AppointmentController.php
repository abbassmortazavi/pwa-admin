<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AppointmentController extends Controller
{
    public function index()
    {
        //part 24 bayad bebinam
        $users = Appointment::query()->with('client')->paginate(10)->through(fn($appointment) => [
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
