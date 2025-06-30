<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DentalForm extends Model
{
    protected $table = 'dental_forms';
    protected $primaryKey = 'DentalFormID';
    public $timestamps = true;

    protected $fillable = [
        'PatientID',
        'FileName',
        'FileContent',
        'FileType',
        'UploadedBy',
        'FormType',
        'UploadDate',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'UploadDate' => 'datetime',
        // 'FileContent' => 'binary'
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