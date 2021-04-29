<?php

namespace App\Http\Controllers;

use App\Models\Callrequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CallrequestsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('requestFromClient');
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
            $callreq = Callrequest::with(['sites','staffs'])->whereIn('site', $sitesIds)->get();
            return response()->json([
                'data' => $callreq
            ]);
        }
    }
    /**
     *  new visiter
     *
     * @param Request $request
     *
     * @throws \Exception
     */
    public function requestFromClient( Request $request ) {
        $callreq = Callrequest::create($request->all());

        return response()->json([
            'status' => true
        ]);
    }
    /**
     * Change status of request
     */
    public function changeStatus (Request $request, $id ){
        $callreq = Callrequest::find($id);
        $staff = \Auth::user()->id;
        $callreq->update([
            'status' => $request->callrequest['status'],
            'staff' => $staff,
            ]);
            // $answer = ['status' => $callreq->status]; 
            $answer = $callreq::with(['sites','staffs']);
            dd($answer);
            return response()->json(['data' =>  $answer], Response::HTTP_OK);
    }
    /**
     * Destroy single resource
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy( $id ) {
        // $visit = Visit::findOrFail($id);
        // $visit->delete();

        // return response()->json([
        //     'status' => true
        // ]);
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
        // $request->validate([
        //     'ids' => 'required|array'
        // ]);
        // Visit::destroy($request->ids);

        // return response()->json([
        //     'status' => true
        // ]);
    }

}
