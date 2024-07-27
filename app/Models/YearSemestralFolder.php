<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YearSemestralFolder extends Model
{
    use HasFactory;

    protected $table = 'year_semestral_folders';
    protected $primaryKey = 'year_semestral_folders_id';

    protected $fillable = [
        'semestral_id',
        'faculty_id',
        'admin_id',
        'folder_name',
    ];

    public function semestralEnd()
    {
        return $this->belongsTo(SemestralEnd::class, 'semestral_id', 'semestral_id');
    }

    public function faculty()
    {
        return $this->belongsTo(FacultyAccount::class, 'faculty_id', 'faculty_account_id');
    }

    public function admin()
    {
        return $this->belongsTo(AdminAccount::class, 'admin_id', 'id');
    }
}