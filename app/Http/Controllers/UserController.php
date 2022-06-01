<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    //Liste der User
    public function index():JsonResponse{
        $users = User::all();
        return response()->json($users, 200);
    }

    ///User finde mit ID
    public function findById(string $id){
        $user = User::where('id', $id)->first();
        return $user != null ? response()->json($user, 200) : response()->json(null, 200);
    }

    //Neuen User speichern
    public function save(Request $request):JsonResponse{
        //Use a transaction for saving model including relations
        DB::beginTransaction();
        try{
            //User anlegen
            $passwort = $request['password'];
            $request['password'] = bcrypt($passwort);
            $user = User::create($request->all());
            DB::commit();
            return response()->json($user, 200);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json("saving offer failed: ".$e->getMessage(), 420);
        }
    }

    public function delete(string $id):JsonResponse{
        $user = User::where('id', $id)->first();
        if($user != null){
            $user->delete();
        }else{
            throw new \Exception("User could not be deleted - does not exist");
        }
        return response()->json('User ('.$id.') successfully deleted.', 200);
    }


}
