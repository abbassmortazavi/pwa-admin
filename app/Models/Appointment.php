<?php

namespace App\Models;

use App\Enums\AppointmentStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'client_id',
        'description',
        'start_date',
        'end_time',
        'status',
    ];
    protected $appends = [
        'format_start_time'
    ];
    protected $casts = [
        'start_date' => 'datetime',
        'end_time' => 'datetime',
        'status' => AppointmentStatus::class
    ];

    /**
     * @return BelongsTo
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function formatStartTime(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->start_time->format('Y-m-d h:i A')
        );
    }
}
