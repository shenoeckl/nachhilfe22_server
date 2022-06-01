<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Offer;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use \Illuminate\Support\Facades\DB;

class OfferController extends Controller
{
    //Listenansicht der Angebote
    public function index():JsonResponse{
        //Alle Angebote und relations with eager loading
        $offers = Offer::with(['user', 'appointments'])->get();
        return response()->json($offers, 200);
    }

    //Offer mit sepzieller ID suchen
    public function findById(int $id){
        $offer = Offer::where('id', $id)
            ->with(['user', 'appointments'])
            ->first();
        return $offer != null ? response()->json($offer, 200) : response()->json(null, 200);
    }

    //Offer von User suchen
    public function findByUserId(int $id){
        $offers = Offer::where('user_id', $id)
            ->with(['user', 'appointments'])->get();
        return $offers != null ? response()->json($offers, 200) : response()->json(null, 200);
    }

    //Offer mit sepziellem status suchen
    public function findByStatus(string $status){
        $offers = Offer::where('status', $status)
            ->with(['user', 'appointments'])->get();
        return $offers != null ? response()->json($offers, 200): response()->json(null, 200);
    }

    //Offer mit sepzieller ID suchen
    public function checkId(string $id){
        $offer = Offer::where('id', $id)->first();
        return $offer != null ? response()->json(true, 200) : response()->json(false, 200);
    }

    //Angebot durch Suchbegriff finden
    public function findBySearchTerm(string $searchTerm):JsonResponse{
        $offers = Offer::with(['user', 'appointments'])
            ->where('title', 'LIKE', '%'.$searchTerm.'%')
            ->orWhere('description', 'LIKE', '%'.$searchTerm.'%')
            ->orWhere('subject', 'LIKE', '%'.$searchTerm.'%')
            ->orWhereHas('user', function($query) use ($searchTerm){
                $query->where('name', 'LIKE', '%'.$searchTerm.'%');
            })->get();
        return response()->json($offers, 200);
    }

    //Neues Angebot speichern
    public function save(Request $request):JsonResponse{
        //Use a transaction for saving model including relations
        DB::beginTransaction();
        try{
            //Angebot anlegen
            $offer = Offer::create($request->all());
            //Appointments speichern
            if(isset($request['appointments'])&& is_array($request['appointments'])){
                foreach ($request['appointments'] as $ap){
                    $appointment = Appointment::firstOrNew(['starttime'=>$ap['starttime'],
                                                            'endtime'=>$ap['endtime'],
                                                            'status'=>$ap['status'],
                                                            'user_id'=>$ap['user_id'],
                                                            'label'=>$ap['label']]);
                    $offer->appointments()->save($appointment);
                }
            }
            DB::commit();
            return response()->json($offer, 200);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json("saving offer failed: ".$e->getMessage(), 420);
        }
    }

    //Angebot bearbeiten
    public function update(Request $request, string $id) : JsonResponse{
        DB::beginTransaction();
        try{
            $offer = Offer::with(['user', 'appointments'])
                ->where('id', $id)->first();
            if($offer != null){
                $offer->update($request->all());
                //delete all old appointments
                $offer->appointments()->delete();
                //save new appointments
                if(isset($request['appointments'])&& is_array($request['appointments'])){
                    foreach ($request['appointments'] as $ap){
                        $appointment = Appointment::firstOrNew(['starttime'=>$ap['starttime'],
                                                                'endtime'=>$ap['endtime'],
                                                                'status'=>$ap['status'],
                                                                'user_id'=>$ap['user_id'],
                                                                'label'=>$ap['label']]);
                        $offer->appointments()->save($appointment);
                    }
                }
                $offer->save();
            }
            DB::commit();
            $offer1 = Offer::with(['user', 'appointments'])
                ->where('id', $id)->first();
            //return http response
            return response()->json($offer1, 201);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json("updating offer failed: ".$e->getMessage(), 420);
        }

    }

    //Angebot bearbeiten
    public function updateStatus(Request $request, string $status, string $id) : JsonResponse{
        DB::beginTransaction();
        try{
            $offer = Offer::with(['user', 'appointments'])
                ->where('id', $id)->first();
            if($offer != null){
                $offer->update($request->all());
                $offer->save();
            }
            DB::commit();
            $offer1 = Offer::with(['user', 'appointments'])
                ->where('id', $id)->first();
            //return http response
            return response()->json($offer1, 201);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json("updating offer status failed: ".$e->getMessage(), 420);
        }
    }

    public function delete(string $id):JsonResponse{
        $offer = Offer::where('id', $id)->first();
        if($offer != null){
            $offer->delete();
        }else{
            throw new \Exception("Offer could not be deleted - does not exist");
        }
        return response()->json('offer ('.$id.') successfully deleted.', 200);
    }


}
