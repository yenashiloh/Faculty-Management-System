<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FacultyAccount extends Authenticatable
{
    use HasFactory;

    protected $table = 'faculty_account';
    protected $primaryKey = 'faculty_account_id'; 
    public $incrementing = true;
    protected $keyType = 'int'; 

    protected $fillable = [
        'email',
        'password',
        'api_token',
        'email_verified_at',
        'verify_status',
        'verification_code',
    ];

    protected $hidden = [
        'password',
        'api_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        
        'verify_status' => 'boolean',
    ];

    public $timestamps = true;

    public function personalDetails()
    {
        return $this->hasOne(FacultyPersonalDetails::class, 'faculty_account_id', 'faculty_account_id');
    }

    
}