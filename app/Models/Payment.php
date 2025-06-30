<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';
    protected $primaryKey = 'PaymentID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'BillingID',
        'PatientID',
        'PaymentMethodID',
        'AmountPaid',
        'ReferenceID',
        'PaymentDate',
        'Change',
        'ProcessedBy',
        'ApprovalCode',
        'LOE',         
    ];

    protected $casts = [
        'AmountPaid' => 'decimal:2',
        'PaymentDate' => 'datetime',
        'Change' => 'decimal:2',
        'ApprovalCode' => 'string',
        'LOE' => 'string',         
    ];

    public function billing()
    {
        return $this->belongsTo(Billing::class, 'BillingID');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'PaymentMethodID');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'PatientID');
    }
}
