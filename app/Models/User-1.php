<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';
    protected $primaryKey = 'UserID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'LastName',
        'FirstName',
        'MiddleName',
        'ContactNumber',
        'HomeTelephoneNumber',
        'OfficeNumber',
        'Email',
        'BirthDate',
        'Age',
        'Gender',
        'Address',
    ];

    // Relationship with UserAccount
    public function userAccount()
    {
        return $this->hasOne(UserAccount::class, 'UserID');
    }

    // Relationship with Patient
    public function patient()
    {
        return $this->hasOne(Patient::class, 'UserID', 'UserID');
    }

    // Relationship with Dentist
    public function dentist()
    {
        return $this->hasOne(Dentist::class, 'UserID');
    }

    // Relationship with HRAdmin
    public function hradmin()
    {
        return $this->hasOne(HRAdmin::class, 'UserID');
    }

    // Relationship with Billings (for patients)
    public function billings()
    {
        return $this->hasMany(Billing::class, 'PatientID');
    }

    // Relationship with Payments (if user has payments)
    public function payments()
    {
        return $this->hasMany(Payment::class, 'PatientID'); // Ensure this exists in payments
    }

    // Relationship with PaymentMethod (if applicable)
    public function paymentMethods()
    {
        return $this->hasMany(PaymentMethod::class, 'UserID'); // If users store preferred payment methods
    }

    // Override the password to use the user_accounts table
    public function getAuthPassword()
    {
        return $this->userAccount ? $this->userAccount->Password : null;
    }

    public function isDentist()
    {
        return $this->userAccount && $this->userAccount->UserType === 'Dentist';
    }

    public function isHRAdmin()
    {
        return $this->userAccount && $this->userAccount->UserType === 'HRAdmin';
    }

}
