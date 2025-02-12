<?php

namespace App\Http\Controllers;
use App\Models\CarUser;
use App\Models\Car;
use App\Models\Usser;
use Illuminate\Http\Request;

class CarUserController extends Controller
{
    public function storeCU(Request $request)
{
    $validated = $request->validate([
        'user_id' => 'required|integer', 
        'car_id' => 'required|integer', 
        'from' => 'required|date', 
        'until' => 'required|integer', 
        'price' => 'required|numeric', 
        'paid' => 'required|numeric',
        'state' => 'required|integer|in:0,1', 
    ]);

    $validated['state'] = '0';


    $carUser = CarUser::create($validated);

    $car = Car::find($validated['car_id']);
    if ($car) {
        $car->state = 'In progress'; 
        $car->save();
    }
    $usser = Usser::find($validated['user_id']);
    if ($usser) {
        $usser->stateu =1; 
        $usser->save();
    }

    return response()->json($carUser, 201);
}
    public function getCU(){

        $carUser =CarUser::all();
    
        if($carUser ->isEmpty()){
            return response()->json(['message'=>'car not Fond']);
        }else{
            return response()->json($carUser);

        }
    }
    
    public function getAllReservations()
    {
        $reservations = CarUser::with(['user', 'car'])->get();

        $formattedReservations = $reservations->map(function ($reservation) {
            return [
                'id'=>$reservation->id,
                'user_id'=>$reservation->user->id,
                'car_id'=>$reservation ->car->id,
                'user_name' => $reservation->user->name ?? 'Unknown',
                'car_name' => $reservation->car->name ?? 'Unknown',
                'car_model' =>$reservation->car->model,
                'matricul' =>$reservation ->car->matricul,
                'from' => $reservation->from,
                'until' => $reservation->until,
                'price' => $reservation->price,
                'paid' => $reservation->paid,
                'state' =>$reservation ->state,
                'stateu' =>$reservation->user->stateu,
            ];
        });

        return response()->json($formattedReservations);
    }
    public function updateState($id)
{
    $carUser = CarUser::find($id);

    if (!$carUser) {
        return response()->json(['message' => 'Reservation not found lala'], 404);
    }

    $carUser->state = 1;
    $carUser->save();

    $car = $carUser->car;
    if ($car) {
        $car->state = 'Available';
        $car->save();
    }
    $usser =$carUser->user;
    if($usser){
        $usser->stateu='0';
        $usser->save();
    }

    return response()->json(['message' => 'State updated to Available successfully'], 200);
}
public function destroy($id)
    {
        $car = CarUser::find($id);

        if (!$car) {
            return response()->json(['message' => 'reservation  not found'], 404);
        }

        $car->delete();
        return response()->json(['message' => 'reservation deleted successfully'], 200);
    }
    public function editRes(Request $request, $id){
        $validated = $request->validate([
            'until' => 'required|integer', 
            'paid' => 'required|numeric',
        ]);

        $car = CarUser::find($id);

        if (!$car) {
            return response()->json(['message' => 'reservation  not found'], 404);
        }
        $car->until = $validated['price'];
        $car->paid = $validated['paid'];
        $car->save();

    return response()->json(['message' => 'reservation updated successfully'], 200);
    
}
    

}

