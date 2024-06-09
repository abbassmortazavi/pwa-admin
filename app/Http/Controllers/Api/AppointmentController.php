<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        //part 24 bayad bebinam
        $users = Appointment::query()->with('client')->paginate(10);
        return response()->json([
            'message' => "Appointment Lists Successfully!",
            'data' => $users,
        ]);
    }
}
