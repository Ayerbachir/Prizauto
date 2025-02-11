<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CarUser extends Pivot
{
    protected $table = 'car_user';

    protected $fillable = [
        'user_id',
        'car_id',
        'from',
        'until',
        'price',
        'paid',
        'state',
    ];

    public function user()
    {
        return $this->belongsTo(Usser::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    /**
     * Automatically update the related Car's state when the CarUser's state is updated.
     */
    
}
