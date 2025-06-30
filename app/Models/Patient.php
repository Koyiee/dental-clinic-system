<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $table = 'patients';
    protected $primaryKey = 'PatientID';
    public $incrementing = false; // Disable auto-increment
    protected $keyType = 'string'; // Change to string for VARCHAR

    protected $fillable = [
        'UserID',
        'Gender',
        'BirthDate',
        'Age',
        'Religion',
        'Nationality',
        'MaritalStatus',
        'HomeAddress',
        'HomeTelephoneNumber',
        'Occupation',
        'OfficeNumber',
        'GuardianID',
        'ReferredBy',
        'GovernmentID',
        'PatientID', // Ensure PatientID is fillable
    ];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID');
    }
}