<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dentist extends Model
{
    use HasFactory;

    protected $table = 'dentists';
    protected $primaryKey = 'DentistID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    // Specify the attributes that are mass assignable
    protected $fillable = [
        'UserID',
        'DayOff',
        'created_at',
        'updated_at',
    ];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class, 'UserID');
    }
}