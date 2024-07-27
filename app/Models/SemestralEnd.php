<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SemestralEnd extends Model
{
    use HasFactory;

    protected $table = 'semestral_end';
    protected $primaryKey = 'semestral_id';
    public $incrementing = true; 
    protected $keyType = 'int';

    protected $fillable = [
        'file_name',
        'trashed',
        'faculty_id', 
        'admin_id',
    ];

    /**
     * Get the faculty associated with the SemestralEnd.
     */
    public function faculty()
    {
        return $this->belongsTo(FacultyPersonalDetails::class, 'faculty_id', 'faculty_account_id');
    }
    
}