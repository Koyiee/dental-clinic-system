<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HRAdmin extends Model
{
    protected $table = 'hradmins'; // Create a new table for hradmin if needed
    protected $primaryKey = 'HRAdminID'; // Change as appropriate
    public $timestamps = true;

    protected $fillable = [
        'UserID',
    ];

    // If you need a relation back to the User model:
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'UserID');
    }
}
