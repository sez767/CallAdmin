<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\Site;
use App\Models\Invite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Notifications\InviteNotification;


class StaffController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('mailregistration');
    }

    /**
     * Index resource
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() {
        //TODO 
        // $staff = \Auth::user()->sites()->first()->staff()->get();
        $ids = \Auth::user()->sites()->get();
        foreach($ids as $id){
            $arr[]=$id->id;
        }   
        $staff = Staff::with('sites')->whereHas('sites', function($q) use($arr){
            $q->where('site_id', $arr);
        })->get();
        
        $staff->each(function ($staff) {
            $staff->append('avatar');
        });

        return response()->json([
            'data' => $staff
        ]);
    }

    
    /**
     * Ivite new user
     *
     * @param Request $request
     *
     * @throws \Exception
     */
    public function invite( Request $request ) {
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:staff,email'
        ]);
        $token = Str::random(20);
        $inv = Invite::create([
            'token' => $token,
            'email' => $request->email,
            'site' => $request->site,
        ]);
        $url = \URL::temporarySignedRoute(
            'mailregistration', now()->addMinutes(300), ['token' => $token]
        );
        \Notification::route('mail', $request->input('email'))->notify(new InviteNotification($url));
    }

    public function mailregistration($token)
    {
        $invite = Invite::where('token', $token)->first();
        return view('auth.mailregister',['invite' => $invite ]);
    }
}
