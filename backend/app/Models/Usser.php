<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Usser extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'nci',
        'stateu',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'nci' => 'integer',
        'phone' => 'integer',
    ];

    public function cars()
{
    return $this->belongsToMany(Car::class, 'car_user')
        ->using(CarUser::class)
        ->withPivot(['from', 'until', 'price', 'paid','state'])
        ->withTimestamps();
}

}
