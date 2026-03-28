<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class SiteLike extends Model
{
    use HasUuids;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'liked_at',
    ];

    protected function casts(): array
    {
        return [
            'liked_at' => 'datetime',
        ];
    }
}
