<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';  // Ensure it matches the name of your table
    protected $primaryKey = 'ServiceID'; // Set the primary key
    public $incrementing = true;  // Auto-incrementing primary key
    protected $keyType = 'int'; // Type of primary key (int)
    public $timestamps = true;

    protected $fillable = [
        'ServiceName', 
        'Description', 
        'Cost',
        'IsMultiVisit',
        'IsActive',
    ];

    protected $casts = [
        'IsMultiVisit' => 'boolean',
        'Cost' => 'decimal:2',
    ];

    public function servicesAvailed()
    {
        return $this->hasMany(ServiceAvailed::class, 'ServiceID');
    }
}
