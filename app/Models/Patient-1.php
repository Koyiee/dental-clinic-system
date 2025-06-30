<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $table = 'patients';  // Ensure it matches the name of your table
    protected $primaryKey = 'PatientID'; // Set the primary key
    public $incrementing = true;  // Auto-incrementing primary key
    protected $keyType = 'int'; // Type of primary key (int)

    // Specify the attributes that are mass assignable
    protected $fillable = [
        'UserID',  // Assuming the foreign key to the users table
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
    ];

    // Disable timestamps if your table doesn't use them
    public $timestamps = true;

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class, 'UserID');
    }
}