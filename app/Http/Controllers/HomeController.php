<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        dd($request->all());
        // $extension = $request->ex;
        return view('video')
            ->with('name', $request->name)
            ->with('pass', $request->ps)
            ->with('role', $request->rl);
    }
}
