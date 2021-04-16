<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\Site;
use App\Models\Callclient;

class VideoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth')->except('video');
    }


    public function videoStaff(Request $request)
    {   
        $staff = Staff::findOrFail($request->user);
        $staff->is_active = 1;
        return view('video')
            ->with('name', $staff->name)
            ->with('pass', $staff->password)
            ->with('extention', 1000 + $staff->id);
    }  
    
    
    public function videoClient(Request $request){
            $client = Callclient::create();
            $client->name = 10000 + $client->id;
            $client->save();
            $clientSite = $request->client;
            $staffs = Site::findOrFail($clientSite)->staff->where('is_active', 1);
            $free = 0;
            foreach($staffs as $staff){
                if (\Cache::has('staffonline-' . $staff->id)){
                    $free = $staff; 
                    $free->is_active = 0;
                    break;
                }   
            }
            
            dd($free);
            return view('video')
                // ->with('name', $staff->name)
                // ->with('pass', $staff->password)
                ->with('extention', 1000 + $free->id);
        
    }
}
