<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\Extention;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('video');;
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

    public function video(Request $request)
    {   
        // dd($request->all());
        if($request->has('rl') && $request->rl == 'staff'){
            $staff = Staff::findOrFail($request->user);
            $extention = Extention::updateOrCreate(
                ['name' => 1000 + $staff->id],
                ['active' => 1]
            );
        
        return view('video')
            ->with('name', $staff->name)
            ->with('pass', $staff->password)
            ->with('extention', $extention->name);
       }
    //    dd($request->all());
       if($request->has('cl')){
        // dd($request->ex);
            $extention = Extention::findOrFail(($request->ex)-1000);
            $extention->active = 0;
            $extention->save();
       }
       return view('video');
    }
}
