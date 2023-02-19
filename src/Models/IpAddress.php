<?php

namespace Brunocfalcao\Tracer\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * A visit ip of any source.
 */
class IpAddress extends Model
{
    use HasFactory;

    protected $casts = [
        'is_blacklisted' => 'boolean',
        'is_throttled' => 'boolean',
    ];
}
