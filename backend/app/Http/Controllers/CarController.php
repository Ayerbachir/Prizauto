<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'  => 'required|string',
            'model' => 'required|string',
            'matricul' =>'required|string',
            'price' => 'required|numeric',
            'state' => 'required|string|in:Available,In progress',
        ]);

        $car = Car::create($validated);

        return response()->json($car, 201);
    }

    public function destroy($id)
    {
        $car = Car::find($id);

        if (!$car) {
            return response()->json(['message' => 'Car not found'], 404);
        }

        $car->delete();
        return response()->json(['message' => 'Car deleted successfully'], 200);
    }

    
    public function index(){

        $car = Car::all();
    
        if($car ->isEmpty()){
            return response()->json(['message'=>'car not Fond']);
        }else{
            return response()->json($car);

        }
    }


    public function getCars(Request $request){

        $query =Car::query();

        if($request->has('name') && $request ->name){
            $query ->where('name',$request->query('name'));
        }
        if($request->has('model') && $request ->model){
            $query ->where('model',$request->query('model'));
        }
        if($request->has('matricul') && $request ->matricul){
            $query ->where('matricul',$request->query('matricul'));
        }
        if($request->has('price') && $request ->price){
            $query ->where('price',$request->query('price'));
        }
        if($request->has('state') && $request ->state){
            $query ->where('state',$request->query('state'));
        }

        $car=$query->get();

        return response()->json($car);
    }
    public function editCar(Request $request, $id){
        $validated = $request->validate([
            'name'  => 'required|string',
            'model' => 'required|string',
            'matricul' =>'required|string',
            'price' => 'required|numeric',
            'state' => 'required|string|in:Available,In progress',
        ]);

        $car = Car::find($id);

        if (!$car) {
            return response()->json(['message' => 'Car not found'], 404);
        }
        $car->name = $validated['name'];
        $car->model = $validated['model'];
        $car->matricul = $validated['matricul'];
        $car->price = $validated['price'];
        $car->state = $validated['state'];
        $car->save();

    return response()->json(['message' => 'Car updated successfully', 'car' => $car], 200);
    
}


    

    

    
    
    

    






}
