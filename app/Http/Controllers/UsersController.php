<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class UsersController extends Controller
{


    public function update(Request $request,$id)
    {
        $data = $request->json()->all();
        $update = User::find($id);
        $update->name=$data['name'];
        $update->locality=$data['locality'];
        
       
         if ($update->save()) {

           return response()->json([
           'status'=> true,
           'data'=>$update
           ]);
       }else{
        return response()->json([
           'status'=> false,
           ]);
       }

    }

    public function delete($id)
    {
        $delete = User::find($id);
       if ($delete->delete()) {
           return response()->json(['status'=> true]);
       }else{
         return response()->json(['status'=> false]);
       }
    }

    public function showAll()
    {
        $users=User::all();

         return response()->json([
            'data'=>  $users,
        ]);
    }

   

    public function showById($id)
    {
        $user = User::find($id);

        return response()->json(["data"=>$user]);
    }

    public function updatePasswordReset(Request $request,$id)
    {
        $data = $request->json()->all();
        $update = User::find($id);
        $check = User::where('id', $id)->exists();
        if($check){

            $update->password=Hash::make( $data['password']);
            $update->save();

            return response()->json(['message' => 'Password updated successfully', 'status'=> true,], 201, []);
        }else{

            return response()->json(['error' => 'Password not found', 'status'=> false,], 401, []);
        }
    }



}
