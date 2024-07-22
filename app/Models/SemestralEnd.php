<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class SemestralEnd extends Model
{
    protected $table = 'semestral_end';
    protected $primaryKey = 'semestral_id';
    public $incrementing = true; // Set this to false if semestral_id is not auto-incrementing
    protected $keyType = 'int'; // Adjust this if semestral_id is not an integer

    protected $fillable = ['file_name']; // Add other fillable fields as needed
}
