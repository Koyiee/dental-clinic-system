<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginTracer extends Model
{
    protected $table = 'login_tracer';
    protected $primaryKey = 'TracerID';
    protected $fillable = ['UserID', 'ActionType', 'Description', 'ActionDate'];

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID', 'UserID');
    }
}