<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Script extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'content',
        'priority',
        'status',
    ];

    public function link(): BelongsToMany
    {
        return $this->belongsToMany(Link::class);
    }
}
