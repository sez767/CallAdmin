<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pages.roles.index', ['constantRoles' => Role::constantRoles()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = new Role();
        $role->fill($request->role);
        $role->save();
        return response()->json(['status' => 'success'], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('admin.pages.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        if(in_array($role->code, Role::constantRoles())) {
            return response()->json(['error' => Role::constantRoleWarning()], Response::HTTP_BAD_REQUEST);
        }
        $role->fill($request->role);
        $role->save();
        return response()->json(['status' => 'success'], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        if(in_array($role->code, Role::constantRoles())) {
            return response()->json(['error' => Role::constantRoleWarning()], Response::HTTP_BAD_REQUEST);
        }
        $role->delete();
        return response()->json(['status' => 'success'], Response::HTTP_OK);
    }

    /**
     * provides vgt with json data
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function rolesData(Request $request)
    {
        $relations = [];
        $scopes = [];
        $builder = new \Builders\VGTBuilder(Role::class, $relations, json_decode($request->queryParams));
        $roles = $builder->get($scopes);
        return response()->json($roles['data'], $roles['response']);
    }
}
