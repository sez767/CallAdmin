<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Call;
use App\Models\Staff;

class CallsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('startCall','endCall','confirmCall');
    }

    /**
     * Index resource
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() {
        $sites = \Auth::user()->sites()->get();
        if(!$sites->isEmpty()){
            foreach($sites as $site){
                $sitesIds[]=$site->id;
            }
            $calls = Call::with(['site', 'staff'])->whereIn('site', $sitesIds)->get();
            return response()->json([
                'data' => $calls
            ]);
        }
    }
    /**
     * Destroy single resource
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy( $id ) {
        $calls = Call::findOrFail($id);
        $calls->delete();

        return response()->json([
            'status' => true
        ]);
    }
    /**
     * Destroy resources by ids
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroyMass( Request $request ) {
        $request->validate([
            'ids' => 'required|array'
        ]);
        Callt::destroy($request->ids);

        return response()->json([
            'status' => true
        ]);
    }
     /*
        call finished -- activate staff staus, save call end-time or save braking call
    */
    public function endCall(Request $request){
        $staff = Staff::findOrFail($request->staff_id);
        $staff->is_active = 1;
        $staff->save();
        
        $call = Call::where('client', $request->client)->first();
        $call->touch();
        $call->save();
        return response()->json([
            'status' => true
        ]);
    }
    /*
        confirm new call
    */
    public function confirmCall(Request $request){
        $staff = Staff::findOrFail($request->staff_id);
        $staff->is_active = 0;
        $staff->save();
        
        $call = Call::where('client', $request->client)->first();
        $call->status = 1;
        $call->save();

        return response()->json([
            'status' => true
        ]);
    }

    /*
        save new call start
    */
    public function startCall(Request $request){
        $call = new Call();
        $call->client = $request->client;
        $call->staff_id = $request->staff_id;
        $call->site = $request->site;
        $call->status = 0;
        $call->save();

        return response()->json([
            'status' => true
        ]);
    }

}
