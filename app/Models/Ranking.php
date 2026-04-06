<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ranking extends Model
{
    protected $fillable = [
        'period_id',
        'stock_id',
        'vector_s',
        'vector_v',
        'rank',
    ];

    protected $casts = [
        'vector_s' => 'decimal:10',
        'vector_v' => 'decimal:10',
        'rank' => 'integer',
    ];

    public function period(): BelongsTo
    {
        return $this->belongsTo(Period::class);
    }

    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class);
    }
}