<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use App\Models\Invite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Notifications\InviteNotification;


class VisitsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('gethead');
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
    public function gethead( Request $request ) {
        $headers = json_encode($request->header());
        $request = new Request([
            'header' => $headers
        ]);
        $this->validate($request, [
            'header' => 'required|unique:visits,header'
        ]);
        
        $visit = Visit::create([
            'header' => $request->header,
        ]);
        }

}
