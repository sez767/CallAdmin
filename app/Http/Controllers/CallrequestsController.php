<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use Illuminate\Http\Request;


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
        // $sites = \Auth::user()->sites()->get();
        // if(!$sites->isEmpty()){
        //     foreach($sites as $site){
        //         $sitesIds[]=$site->id;
        //     }
        //     $visits = Visit::with(['sites'])->whereIn('site', $sitesIds)->get();
        //     return response()->json([
        //         'data' => $visits
        //     ]);
        // }
    }
    /**
     *  new visiter
     *
     * @param Request $request
     *
     * @throws \Exception
     */
    public function requestFromClient( Request $request ) {
        dd($request->all());
        // $visit = Visit::create([
        //     'header' => $hrequest->header,
        //     'site' => $request->client,
        // ]);
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
