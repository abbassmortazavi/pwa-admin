<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $appends = [
        'full_name'
    ];

    /**
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return $this->first_name . '-' . $this->last_name;
    }
}
