<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Link extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'url',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function url(): Attribute
    {
        return Attribute::make(
            set: function (?string $value): ?string {
                if ($value === null) {
                    return null;
                }

                $normalized = trim($value);

                if ($normalized === '') {
                    return $normalized;
                }

                if (! preg_match('/^https?:\/\//i', $normalized)) {
                    $normalized = 'https://'.ltrim($normalized, '/');
                }

                return $normalized;
            },
        );
    }
}
