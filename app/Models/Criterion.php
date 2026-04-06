<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Criterion extends Model
{
    protected $fillable = [
        'code',
        'name',
        'attribute',
        'weight',
        'description',
    ];

    protected $casts = [
        'weight' => 'decimal:4',
    ];

    public function stockValues(): HasMany
    {
        return $this->hasMany(StockValue::class);
    }
}