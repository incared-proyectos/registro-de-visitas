<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Datatables;
use Spatie\Permission\Models\Role;

class RolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $table = Datatables::of(Role::all());

        $table->addColumn('action', function($row){
            return '';
        })->rawColumns(['action']);
        return $table->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $all = $request->all();

        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:roles',
        ]);
         if ($validator->fails()) {
           return response()->json(['error'=>$validator->errors()->all()],422);
        }else{
            $table = new Role();
            $all['guard_name'] = 'web';
            $table->fill($all)->save();
            return response()->json(['success'=>'Registro agregado con exito']);
        }
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $all = $request->all();

        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:roles,name,'.$all['id'],
        ]);
         if ($validator->fails()) {
           return response()->json(['error'=>$validator->errors()->all()],422);
        }else{
            $table = Role::find($all['id']);
            $table->fill($all)->save();
            return response()->json(['success'=>'Registro actualizado con exito']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
    }
}
