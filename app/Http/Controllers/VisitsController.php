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
        $this->middleware('auth')->except('getheaders');
    }

    /**
     * Index resource
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() {
        //
    }

    
    /**
     *  new visiter
     *
     * @param Request $request
     *
     * @throws \Exception
     */
    public function getheaders( Request $request ) {
        dd($request->all());
       
    }

}