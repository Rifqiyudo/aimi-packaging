<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $fillable = [
        'code',
        'name',
        'type',
        'value',
        'start_date',
        'end_date',
        'is_active'
    ];

    /* =====================
     | HELPER METHOD
     ===================== */

    public function isValid()
    {
        return $this->is_active &&
            now()->between($this->start_date, $this->end_date);
    }
}
