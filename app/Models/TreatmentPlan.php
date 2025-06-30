<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TreatmentPlan extends Model
{
    protected $table = 'treatment_plans';
    protected $primaryKey = 'TreatmentPlanID';
    public $timestamps = true;

    protected $fillable = [
        'PatientID',
        'FileName',
        'FileContent',
        'FileType',
        'UploadedBy',
        'Description',
        'UploadDate',
    ];

    protected $casts = [
        'UploadDate' => 'datetime',
        // Removed 'FileContent' => 'binary'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'PatientID');
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'UploadedBy');
    }
}