<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TreatmentProgress extends Model
{
    protected $table = 'treatment_progress';
    protected $primaryKey = 'TreatmentProgressID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'PatientID',
        'TreatmentName',
        'StartDate',
        'VisitCount',
        'EndDate',
        'Status',
        'MarkedCompletedBy',
        'CompletionDate',
    ];

    protected $casts = [
        'Status' => 'string',
        'StartDate' => 'date',
        'EndDate' => 'date',
        'CompletionDate' => 'datetime',
    ];

    public function servicesAvailed()
    {
        return $this->hasMany(ServicesAvailed::class, 'TreatmentProgressID');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'PatientID');
    }
}