<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;

class UserAccount extends Authenticatable
{
    use HasFactory;

    protected $table = 'user_accounts';
    protected $primaryKey = 'AccountID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'UserID',
        'Username',
        'Password',
        'UserType',
        'AccountStatus',
        'last_login_at',
        'password_change_count',
        'previous_password',
    ];

    protected $hidden = [
        'Password',
    ];

    public function getAuthPassword()
    {
        return $this->Password;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID');
    }

    public function checkPassword($password)
    {
        return Hash::check($password, $this->Password);
    }
}