<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExchangeRate extends Model
{
    use HasFactory;
    
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<string>|bool
     */
    protected $guarded = [];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'rate' => 'float',
            'rate_date' => 'date:Y-m-d',
            'retrieved_at' => 'timestamp',
        ];
    }


    /**
     * Applies the given filters to the query builder instance.
     *
     * @param Builder $query   The Eloquent query builder instance.
     * @param array   $filters An associative array of filters to apply to the query.
     *
     * @return void
     */
    protected function scopeFilters(Builder $query, array $filters): void
    {
        if (!empty($filters['currency_from'])) {
            $query->where('currency_from', $filters['currency_from']);
        }

        if (!empty($filters['currency_to'])) {
            $query->where('currency_to', $filters['currency_to']);
        }

        if (!empty($filters['rate_date'])) {
            $query->whereDate('rate_date', $filters['rate_date']);
        }

        if (!empty($filters['retrieved_at'])) {
            $query->whereDate('retrieved_at', $filters['retrieved_at']);
        }
    }
}
