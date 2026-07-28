<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicalRecord extends Model
{
    protected $fillable = [
        'patient_id',
        'title',
        'type',
        'doctor_name',
        'description',
        'record_date'
    ];

    protected $casts = [
        'record_date' => 'date'
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}
