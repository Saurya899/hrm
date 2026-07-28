<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    protected $fillable =[
        'patient_id',
        'doctor_id',
        'department',
        'appointment_date',
        'symptoms',
        'consultation_type',
        'status',
        'token_number'
    ];

    protected $casts = [
        'appointment_date' => 'datetime'
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
}
