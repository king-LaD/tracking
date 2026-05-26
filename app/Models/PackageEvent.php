<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PackageEvent extends Model
{
    protected $fillable = [
        'package_id',
        'status_description',
        'event_title',
        'location',
        'event_date'
    ];

    protected $casts = [
        'event_date' => 'datetime',
    ];

    // Relation inverse : Un événement appartient à un seul colis
    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }
}