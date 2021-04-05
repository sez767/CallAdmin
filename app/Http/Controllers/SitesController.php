<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Http\Requests\ClientStoreRequest;
use Illuminate\Http\Request;

class SitesController extends Controller
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
     * Index resource
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() {
        $sites = \Auth::user()->sites()->get();

        return response()->json([
            'data' => $sites
        ]);
    }

    /**
     * Get single resource
     *
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id) {
        $site = Site::findOrFail($id);
        $site->append('avatar');
        $site->append('avatar_filename');

        return response()->json([
            'data' => $site
        ]);
    }

    /**
     * Store new resource
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store( Request $request ) {
        $staff=\Auth::user();
        $site = new Site;
        $site->fill($request->all());
        if (filled($request->file_id)) {
            $site->file_id = $request->file_id;
        }
        $site->owner = $staff->id;
        $site->save();
        $site->staff()->attach($staff);
        $site->load('file');
        $site->append('avatar');

        return response()->json([
            'created' => true,
            'data' => [
                'id' => $site->id
            ]
        ]);
    }

    /**
     * Update single resource
     *
     * @param Request $request
     * @param Client $client
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id ) {
        $site = Site::findOrFail($id);
        $site->fill($request->all());
        if (filled($request->file_id)) {
            $site->file_id = $request->file_id;
        }
        $site->save();
        $site->append('avatar');

        return response()->json([
            'status' => true,
            'data' => $site
        ]);
    }

    /**
     * Destroy single resource
     *
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($id) {
        $site = Site::findOrFail($id);
        if($site->file){
            $site->file->delete();
        };
        $site->staff()->detach();
        $site->delete();

        return response()->json([
            'status' => true
        ]);
    }

    /**
     * Destroy resources by ids
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroyMass( Request $request ) {
        $request->validate([
            'ids' => 'required|array'
        ]);

        Site::destroy($request->ids);

        return response()->json([
            'status' => true
        ]);
    }
}
