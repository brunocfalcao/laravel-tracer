<?php

namespace Brunocfalcao\Tracer\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Eduka\Cube\Models\ApplicationLog;

class Goal extends Model
{
    use HasFactory;

    protected $casts = [
        'attributes' => 'array',
    ];

    // Relationship verified.
    public function visits()
    {
        return $this->hasMany(Visit::class);
    }

    // Relationship verified.
    public function logs()
    {
        return $this->morphMany(ApplicationLog::class, 'causable');
    }
}
