<?php

namespace App\Http\Controllers;

use App\Models\Usser;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function storeU(Request $request)
{
    // Validate incoming request
    $validated = $request->validate([
        'name'  => 'required|string',
        'email' => 'required|string',
        'password' => 'required|string',
        'phone' => 'required|digits:8',
        'nci'   => 'required|digits:8',
        'stateu' => 'required|integer|in:0,1',
    ]);

    // Check if 'phone' or 'nci' already exists in the database
    $existingUser = Usser::where('phone', $validated['phone'])->first();
    $existingNci = Usser::where('nci', $validated['nci'])->first();

    // If either phone or nci exists, return error
    if ($existingUser) {
        return response()->json(['message' => 'User with this phone number already exists'], 400);
    }

    if ($existingNci) {
        return response()->json(['message' => 'User with this NCI already exists'], 400);
    }

    // Set stateu to 0
    $validated['stateu'] = 0;

    // Create the new user
    $user = Usser::create($validated);

    return response()->json($user, 201);
}

    public function destroyU($id)
    {
        $user = Usser::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();
        return response()->json(['message' => 'User deleted successfully'], 200);
    }

    
    public function indexU(){

        $user = Usser::all();
    
        if($user ->isEmpty()){
            return response()->json(['message'=>'user not Fond']);
        }else{
            return response()->json($user);

        }
    }
    


    public function getUsers(Request $request){

        $query =Usser::query();

        if($request->has('name') && $request ->name){
            $query ->where('name',$request->query('name'));
        }
        if($request->has('email') && $request ->email){
            $query ->where('email',$request->query('email'));
        }
        if($request->has('password') && $request ->password){
            $query ->where('password',$request->query('password'));
        }
        if($request->has('phone') && $request ->phone){
            $query ->where('phone',$request->query('phone'));
        }
        if($request->has('nci') && $request ->nci){
            $query ->where('nci',$request->query('nci'));
        }
        

        $user=$query->get();

        return response()->json($user);
    }
    public function editUser(Request $request, $id){
        $validated = $request->validate([
            'name'  => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string',
            'phone' => 'required|digits:8',
            'nci'   => 'required|digits:8',
 
        ]);

        $user = Usser::find($id);

        if (!$user) {
            return response()->json(['message' => 'user not found'], 404);
        }
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = $validated['password'];
        $user->phone = $validated['phone'];
        $user->nci = $validated['nci'];

        $user->save();

    return response()->json(['message' => 'user updated successfully', 'user' => $user], 200);
}


    

    

    
    
    

    






}
