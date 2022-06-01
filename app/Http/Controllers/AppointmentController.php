<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Offer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use \Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    //Alle Termine
    //Listenansicht der Angebote
    public function index():JsonResponse{
        //Alle Angebote und relations with eager loading
        $appointment = Appointment::with(['user', 'offer'])->get();
        return response()->json($appointment, 200);
    }

    //Angebot nach ID finden
    public function findById(string $id){
        $appointment = Appointment::where('id', $id)
            ->with(['user', 'offer'])
            ->first();
        return $appointment != null ? response()->json($appointment, 200) : response()->json(null, 200);
    }

    //Angebot mit status finden
    public function findByStatus(string $status){
        $ap = Appointment::where('status', $status)->get();
        return $ap != null ? response()->json($ap, 200): response()->json(null, 200);
    }

    //Termin von Person finden
    public function findByUserId(int $id){
        $ap = Appointment::where('user_id', $id)->get();
        return $ap != null ? response()->json($ap, 200): response()->json(null, 200);
    }

    //Neuen Termin speichern
    public function save(Request $request):JsonResponse{
        //Use a transaction for saving model including relations
        DB::beginTransaction();
        try{
            //Termin anlegen
            //echo ($request);
            $appointment = Appointment::create($request->all());
            DB::commit();
            return response()->json($appointment, 200);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json("saving appointment failed: ".$e->getMessage(), 420);
        }
    }

    //Termin bearbeiten
    public function update(Request $request, string $id) : JsonResponse{
        DB::beginTransaction();
        try{
            $appointment = Appointment::with(['user', 'offer'])
                ->where('id', $id)->first();
            if($appointment != null) {
                $appointment->update($request->all());
                $appointment->save();
            }
            DB::commit();
            $appointment1 = Appointment::with(['user', 'offer'])
                ->where('id', $id)->first();
            //return http response
            return response()->json($appointment1, 201);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json("updating appointment failed: ".$e->getMessage(), 420);
        }

    }

    public function delete(string $id):JsonResponse{
        $appointment = Appointment::where('id', $id)->first();
        if($appointment != null){
            $appointment->delete();
        }else{
            throw new \Exception("Appointment could not be deleted - does not exist");
        }
        return response()->json('Appointment ('.$id.') successfully deleted.', 200);
    }


}
