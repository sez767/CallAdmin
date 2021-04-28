<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\Site;
use App\Models\Callclient;
use App\Models\Call;

class VideoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */ 
    public function videoStaff(Request $request)
    {   
        $staff = Staff::findOrFail($request->user);
        $staff->is_active = 1;
        $staff->save();
        return view('videocall')
            ->with('role', 'staff')
            ->with('name', $staff->name)
            ->with('staffId', $staff->id)
            ->with('pass', $staff->password);
    } 
    
    public function videoClient(Request $request)
    {
        $client = Callclient::create();
        $client->name = '10000' + $client->id;
        $client->save();
        $clientSite = $request->client;
        $staffs = null;
        $free = null;
        $oname = null;
        $staffs = Site::findOrFail($clientSite)->staff->where('is_active', 1);
        if($staffs){
          foreach($staffs as $staff){
                if (\Cache::has('staffonline-' . $staff->id)){
                    $staff->is_active = 0;
                    $staff->save();
                    $free = $staff; 
                    break;
                }   
            }   
        }
        if($free){
            $oname = $free->name;
        }
        return view('videocall')
            ->with('role', 'user')
            ->with('name', $client->name)
            ->with('pass', $client->name)
            ->with('operator', $oname);    
    }

    // Activate staff after call finished
    
    public function videoEnded(Request $request){
        $staff = Staff::findOrFail($request->staff);
        $staff->is_active = 1;
        $staff->save();

        return response()->json([
            'status' => true
        ]);
    }

    public function videoCall(Request $request){
        $call = Call::create();
        $call->client = $request->client;
        $call->staff_id = $request->staff_id;
        $call->source = 1;
        $call->save();

        return response()->json([
            'status' => true
        ]);
    }
}
