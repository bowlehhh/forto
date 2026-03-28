<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasUuids;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'token',
        'name',
        'first_visited_at',
        'last_visited_at',
    ];

    protected function casts(): array
    {
        return [
            'first_visited_at' => 'datetime',
            'last_visited_at' => 'datetime',
        ];
    }
}
