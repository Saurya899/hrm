<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Doctor extends Model
{
    protected $fillable = [
        'user_id',
        'department',
        'license_id',
        'bio',
        'profile_photo',
        'available_days',
        'start_time',
        'end_time',
        'consultation_fee'

    ];

    protected $casts = [
        'available_days' => 'array'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


     public function getProfilePhotoUrlAttribute(){
        $photo =$this->profile_photo;
        if(!empty($photo)){
            if(str_starts_with($photo,'http://') || 
                str_starts_with($photo,'https://')){
                 return $photo;
        }
            $possiblePaths= [
                $photo,
                'super-admin/profile/'.$photo,
                'doctors/profile/'.$photo,
                'uploads/profile/'.$photo,
                'uploads/profile_photos/'.$photo,

                ];

                foreach($possiblePaths as $path){
                    
                    if(file_exists(public_path($path))){
                        return asset($path);
                    }
                }
        }
        $name = $this->user->name?:'Doctor';
        return 'https://ui-avatars.com/api/?name='.urlencode($name).
        '&background=0D8ABC&color=fff&bold=true&rounded=true';

    }
}
