<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    protected $table = 'medical_records';
    protected $primaryKey = 'MedicalRecordID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'PatientID',
        'FileName',
        'FileContent',
        'FileType',
        'RecordType',
        'UploadDate',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'UploadDate' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'PatientID');
    }
}