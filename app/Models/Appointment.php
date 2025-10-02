<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointments';
    protected $primaryKey = 'AppointmentID';
    public $incrementing = true;    
    protected $keyType = 'int';
    public $timestamps = true;

    // Define valid statuses (optional but recommended)
    const STATUSES = [
        'Pending' => 'Pending',
        'Confirmed' => 'Confirmed',
        'Completed' => 'Completed',
        'Cancelled' => 'Cancelled',
        'Declined' => 'Declined',
        'No Show' => 'No Show',
    ];

    // Define fillable fields to allow mass assignment
    protected $fillable = [
        'AppointmentDate',
        'AppointmentTime',
        'DentistID',
        'PatientID',
        'PatientNote',
        'AppointmentStatus',
        'created_at',
        'updated_at',
    ];

    // Define relationships
    public function dentist()
    {
        return $this->belongsTo(Dentist::class, 'DentistID');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'PatientID');
    }

    public function servicesAvailed()
    {
        return $this->hasMany(ServicesAvailed::class, 'AppointmentID')->with('service');
    }

    // Optional: Accessor to get serviceRequested as a string (if needed)
    public function getServiceRequestedAttribute()
    {
        return $this->servicesAvailed->pluck('service.ServiceName')->implode(', ');
    }

    public function billing()
    {
        return $this->hasOne(Billing::class, 'AppointmentID');
    }
}
