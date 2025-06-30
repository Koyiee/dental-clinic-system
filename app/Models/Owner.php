<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;

    protected $table = 'owners';
    protected $primaryKey = 'OwnerID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'UserID',
        'IsSuperOwner',
    ];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID');
    }
}
