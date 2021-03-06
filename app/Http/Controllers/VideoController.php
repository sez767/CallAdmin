<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\Site;
use App\Models\Callclient;

class VideoController extends Controller
{
    /**
     * Video window for satff (when login into adminKA)
     *
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

    /**
     * Video window for client
     *
     */
    public function videoClient(Request $request)
    {
        $client = Callclient::create();
        $client->name = '10000' + $client->id;
        $client->save();
        $clientSite = $request->client;
        $staffs = null;
        $free = null;
        $staffId = null;
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
            $staffId = $free->id;
        }
        return view('videocall')
            ->with('role', 'user')
            ->with('name', $client->name)
            ->with('pass', $client->name)
            ->with('site', $clientSite)
            ->with('staffId', $staffId)
            ->with('operator', $oname);    
    }

}
