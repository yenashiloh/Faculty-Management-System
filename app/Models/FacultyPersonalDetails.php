<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacultyPersonalDetails extends Model
{
    protected $table = 'faculty_personal_details';
    protected $primaryKey = 'faculty_account_id';

    protected $fillable = [
        'faculty_account_id',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'birthday',
        'sex',
        'department',
        'id_number',
        'employee_type',
        'phone_number'
    ];
    public $timestamps = true;
    public function faculty()
{
    return $this->belongsTo(Faculty::class, 'faculty_account_id');
}

}
