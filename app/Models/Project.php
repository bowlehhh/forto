<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasUuids;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'title',
        'category',
        'summary',
        'stack',
        'status',
        'github_url',
    ];

    protected function casts(): array
    {
        return [
            'stack' => 'array',
        ];
    }
}
