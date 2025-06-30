<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $table = 'payment_methods';
    protected $primaryKey = 'PaymentMethodID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'MethodType',
        'Details',
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class, 'PaymentMethodID');
    }

    

}
