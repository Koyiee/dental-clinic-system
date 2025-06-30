<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DentalPhoto extends Model
{
    protected $table = 'dental_photos';
    protected $primaryKey = 'DentalPhotoID';
    public $timestamps = true;

    protected $fillable = [
        'PatientID',
        'FileName',
        'FileContent',
        'FileType',
        'UploadedBy',
        'Description',
        'UploadDate',
        'created_at',
        'updated_at',
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