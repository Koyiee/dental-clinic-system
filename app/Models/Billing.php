<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    protected $table = 'billings';
    protected $primaryKey = 'BillingID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'AppointmentID',
        'TotalAmount',
        'Discount',
        'Balance',
        'BillingStatus',
        'Remarks',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'TotalAmount' => 'decimal:2',
        'Balance' => 'decimal:2',
        'Discount' => 'decimal:2',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'AppointmentID');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'BillingID');
    }
}