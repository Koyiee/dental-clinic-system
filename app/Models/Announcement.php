<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Announcement extends Model
{
    use HasFactory, SoftDeletes;

    // Match the exact column name from the database
    protected $primaryKey = 'AnnouncementID'; // Capital 'ID' to match the database

    protected $fillable = [
        'AnnouncementTitle',
        'AnnouncementDescription',
        'AnnouncementPicture',
        'TargetUser',
        'Priority',
        'StartDate',
        'EndDate',
        'CreatedBy',
        'Status',
        'deleted_at',
    ];

    protected $casts = [
        'StartDate' => 'datetime',
        'EndDate' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public $incrementing = true;

    protected $visible = [
        'AnnouncementID', // Match the $primaryKey
        'AnnouncementTitle',
        'AnnouncementDescription',
        'AnnouncementPicture',
        'TargetUser',
        'Priority',
        'StartDate',
        'EndDate',
        'CreatedBy',
        'Status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}