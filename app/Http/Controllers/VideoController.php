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
    // public function videoStaff(Request $request)
    // {   
    //     $staff = Staff::findOrFail($request->user);
    //     $staff->is_active = 1;
    //     return view('video')
    //         ->with('role', 'staff')
    //         ->with('name', $staff->name)
    //         ->with('pass', $staff->password)
    //         ->with('extention', 1000 + $staff->id);
    // }  
    public function videoStaff(Request $request)
    {   
        $staff = Staff::findOrFail($request->user);
        $staff->is_active = 1;
        return view('videocall')
            ->with('role', 'staff')
            ->with('name', $staff->name)
            ->with('pass', $staff->password);
    } 
    
    public function videoClient(Request $request)
    {
        $client = Callclient::create();
        $client->name = '10000' + $client->id;
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
        //DO SMSNG when NOT FOUD
        // dd($free);
        return view('video')
            ->with('role', 'user')
            ->with('name', $client->name)
            ->with('pass', $client->name);    
    }
}
