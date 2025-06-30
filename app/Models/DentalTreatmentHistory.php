<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DentalTreatmentHistory extends Model
{
    protected $table = 'dental_treatment_history';
    protected $primaryKey = 'TreatmentHistoryID';
    public $timestamps = true;

    protected $fillable = [
        'PatientID',
        'FileName',
        'FileContent',
        'FileType',
        'UploadedBy',
        'TreatmentDate',
        'Notes',
        'UploadDate',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'UploadDate' => 'datetime',
        'TreatmentDate' => 'date',
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