<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'profile_photo',
    ];

    public function doctor(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Doctor::class);
    }

    public function patient(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Patient::class);
    }
    public function getProfilePhotoUrlAttribute(){
        $photo =null;
        if($this->role==='doctor' && $this->doctor && !empty($this->doctor->profile_photo)){
            $photo = $this->doctor->profile_photo;
        }
        elseif($this->role==='patient' && $this->patient && !empty($this->patient->profile)){
            $photo = $this->patient->profile;
        }
        elseif(!empty($this->profile_photo)){
            $photo = $this->profile_photo;
        }

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
        $name = $this->name?:'User';
        return 'https://ui-avatars.com/api/?name='.urlencode($name).
        '&background=0D8ABC&color=fff&bold=true&rounded=true';

    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
