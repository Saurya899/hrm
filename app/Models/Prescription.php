<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prescription extends Model
{
    protected $fillable = [
        'patient_id',
        'medicine_name',
        'dosage',
        'duration',
        'prescribed_by',
        'status'
    ];

    public function patient():BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}
