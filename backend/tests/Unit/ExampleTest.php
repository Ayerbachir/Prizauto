<?php

namespace Tests\Unit;

use App\Models\CarUser;
use App\Models\Usser;
use App\Models\Car;
use Tests\TestCase;
class ReservationTest extends TestCase
{
    public function test_create_reservation()
    {
        $Usser = Usser::factory()->create();
        $car = Car::factory()->create(['state' => 'available']);

        $reservation = CarUser::create([
            'user_id' => $Usser->id,
            'car_id' => $car->id,
            'start_date' => now(),
            'end_date' => now()->addDays(3),
            'price' => 150
        ]);

        $this->assertDatabaseHas('reservations', [
            'user_id' => $Usser->id,
            'car_id' => $car->id
        ]);
    }
}
