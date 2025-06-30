<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientNote extends Model
{
    use HasFactory;

    protected $table = 'patient_notes';
    protected $primaryKey = 'NoteID';
    public $incrementing = true;
    protected $keyType = 'int';

    // Specify the attributes that are mass assignable
    protected $fillable = [
        'PatientID',
        'DentistID',
        'HRAdminID',
        'NoteDescription',
    ];

    // Enable timestamps
    public $timestamps = true;

    // Define the relationship with the Patient model
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'PatientID');
    }

    // Define the relationship with the User model (for Dentist)
    public function dentist()
    {
        return $this->belongsTo(User::class, 'DentistID');
    }

    // Define the relationship with the HRAdmin model
    public function hradmin()
    {
        return $this->belongsTo(HRAdmin::class, 'HRAdminID');
    }
}
