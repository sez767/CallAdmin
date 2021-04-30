<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Call;
use App\Models\Callreqest;
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
        $site = \Auth::user()->sites()->first();
        $c = $site->calls()->count();
        dd($c);
    }
}
