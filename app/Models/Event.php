<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "start",
        "end",
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(TypeEvent::class, 'tipo_evento');
    }
}
