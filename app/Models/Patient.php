<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Patient extends Model
{
    protected $fillable = [
        'user_id',
        'age',
        'gender',
        'blood_group',
        'disease',
        'number',
        'address',
        'profile'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function medicalRecords(): HasMany
    {
        return $this->hasMany(MedicalRecord::class);
    }

    public function prescriptions(): HasMany
    {
        return $this->hasMany(prescription::class);
    }
    public function labDocuments(): HasMany
    {
        return $this->hasMany(LabDocument::class);
    }

    public function invoices(): HasMany
    {

        return $this->hasMany(Invoice::class);
    }


    public function getProfilePhotoUrlAttribute()
    {
        $photo = $this->profile;
        if (!empty($photo)) {
            if (
                str_starts_with($photo, 'http://') ||
                str_starts_with($photo, 'https://')
            ) {
                return $photo;
            }
            $possiblePaths = [
                $photo,
                'super-admin/profile/' . $photo,
                'doctors/profile/' . $photo,
                'uploads/profile/' . $photo,
                'uploads/profile_photos/' . $photo,

            ];

            foreach ($possiblePaths as $path) {

                if (file_exists(public_path($path))) {
                    return asset($path);
                }
            }
        }
        $name = $this->user->name ?: 'Patient';
        return 'https://ui-avatars.com/api/?name=' . urlencode($name) .
            '&background=0D8ABC&color=fff&bold=true&rounded=true';

    }
}
