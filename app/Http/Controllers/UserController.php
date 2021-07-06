<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

use Yajra\Datatables\Datatables;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {   
    
        $table = Datatables::of(User::with('roles')->get());
        $table->addColumn('action', function($row){
            return '';
        })->rawColumns(['action']);
        return $table->make(true);
    }

    /*
    *
    * Roles all 
    *
    */
    public function rolesAll(){
        return Role::all();
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
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
           return response()->json(['error'=>$validator->errors()->all()],422);
        }else{

            $table = User::create(
                [
                    'name'=>$all['name'],
                    'email'=>$all['email'],
                    'password'=>Hash::make($all['password']),
                ]
            );
          
            $table->assignRole($all['rol']);

            return response()->json(['success'=>'Registro agregado con exito','url'=>url('visitas')]);
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
        return User::with('roles')->find($id);
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$all['id']
        ]);
        if ($validator->fails()) {
           return response()->json(['error'=>$validator->errors()->all()],422);
        }else{
            $table = User::find($all['id']);
            $all['password'] = (!empty($all['password'])) ? Hash::make($all['password']) : $table->password;

            $table->fill($all)->save();
            $table->syncRoles([$all['rol']]);

            return response()->json(['success'=>'Registro actualizado con exito','url'=>url('visitas')]);
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
        $all = $request->all();
        $user = User::find($all['id_data']);
        if (!empty($user)) {
            $user->delete();
        }
    }
}
