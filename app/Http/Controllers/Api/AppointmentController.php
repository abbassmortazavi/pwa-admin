<?php

namespace App\Http\Controllers\Api;

use App\Enums\AppointmentStatus;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
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
            ->paginate(50)
            ->through(fn($appointment) => [
                'id' => $appointment->id,
                'start_date' => $appointment->start_date->format('Y-m-d h:i A'),
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

    /**
     * @return Collection
     */
    public function getStatus()
    {
        $case = AppointmentStatus::cases();
       return collect($case)->map(function ($status) {
            return [
                'name' => Str::lower($status->name),
                'color' => $status->color(),
                'value' => $status->value,
                'count' => $this->getStatusCount($status->value)
            ];
        });
    }

    /**
     * @param int $value
     * @return int
     */
    private function getStatusCount(int $value)
    {
        //az 28 bayad bebinam
        return Appointment::query()->where('status', $value)->count();
    }

    public function store(Request $request)
    {
        return Appointment::query()->create($request->all());
    }
}
