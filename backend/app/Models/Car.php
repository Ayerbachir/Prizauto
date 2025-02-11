<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'model',
        'matricul',
        'price',
        'state',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'nci' => 'integer',
        'price' => 'float',
    ];
    

    public function users()
{
    return $this->belongsToMany(Usser::class, 'car_user')
        ->using(CarUser::class) 
        ->withPivot(['from', 'until', 'price', 'paid',"state"])
        ->withTimestamps();
}
    

}
