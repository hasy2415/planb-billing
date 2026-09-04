<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'phone',
        'vehicle_number',
        'vehicle_model',
        'services',
        'amounts',
    ];

    protected $casts = [
        'services' => 'array',
        'amounts' => 'array',
    ];

    /**
     * Calculate total from amounts array.
     */
    public function getTotalAttribute()
    {
        $amounts = $this->amounts ?? [];
        $total = 0;

        foreach ($amounts as $a) {
            $total += (float) $a;
        }

        return $total;
    }
}
