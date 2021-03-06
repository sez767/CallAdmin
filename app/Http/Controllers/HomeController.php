<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Call;
use App\Models\Callrequest;
use App\Models\Visit;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function getAllCounts()
    {
        $sites = \Auth::user()->sites()->get();
        if(!$sites->isEmpty()){
            foreach($sites as $site){
                $sitesIds[]=$site->id;
            }
            $callsCount = Call::whereIn('site', $sitesIds)->count();
            $visitsCount = Visit::whereIn('site', $sitesIds)->count(); 
            $callreqCount = Callrequest::whereIn('site', $sitesIds)->count();  
            
            return response()->json([
                'calls' => $callsCount,
                'orders' => $callreqCount,
                'visits' => $visitsCount,
            ]);
        }
   
    }
}
