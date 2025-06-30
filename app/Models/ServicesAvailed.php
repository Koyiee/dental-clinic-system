<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicesAvailed extends Model
{
    protected $table = 'services_availed';
    protected $primaryKey = 'ServiceAvailedID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'AppointmentID',
        'ServiceID',
        'TreatmentProgressID',
        'NextAppointmentID',
        'Status',
        'UpdatedPrice',
    ];

    protected $casts = [
        'UpdatedPrice' => 'decimal:2',
    ];

    public function getPriceAttribute()
    {
        return $this->UpdatedPrice ?? $this->service->Cost;
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'AppointmentID');
    }

    public function billing()
    {
        return $this->belongsTo(Billing::class, 'BillingID');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'ServiceID');
    }

    public function treatmentProgress()
    {
        return $this->belongsTo(TreatmentProgress::class, 'TreatmentProgressID');
    }

    public function nextAppointment()
    {
        return $this->belongsTo(Appointment::class, 'NextAppointmentID');
    }
}
