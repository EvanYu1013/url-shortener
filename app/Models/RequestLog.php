<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequestLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'link_id',
        'ip',
        'url',
        'user_agent',
        'platform',
        'browser',
        'device',
        'country',
        'city',
        'latitude',
        'longitude',
        'language',
        'fingerprint',
        'referer',
        'meta',
    ];

    protected $casts = [
        'language' => 'array',
        'meta' => 'array',
    ];

    public function link(): BelongsTo
    {
        return $this->belongsTo(Link::class);
    }
}
