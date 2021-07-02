<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Datatables;
use App\Models\Visita;
use App\Models\Entidad;
use App\Models\Motivo;
use App\Models\Sede;
use App\Models\Oficina;
use App\Models\Empleado;
use Storage;
use DB;
use Auth;
class VisitaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $visita = new Visita();
        $table = Datatables::of($visita->mapvisita($request));

        $table->addColumn('action', function($row){
            return 'delete';
        })->addColumn('hora_salida', function($row){
            if (!empty($row['hora_salida'])) {
                return $row['hora_salida'];
            }
            return 0;
        })->addColumn('actionviewimg', function($row){
            if (!empty($row['srcfoto'])) {
                return $row['srcfoto'];
            }
            return '';
        })->rawColumns(['action']);
        return $table->make(true);
    }
    public function selects(){
        return [
            'entidad'=>Entidad::all(),
            'motivos'=>Motivo::all(),
            'sedes'=>Sede::all(),
            'oficinas'=>Oficina::all(),
            'empleados'=>Empleado::all(),
        ];
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
            'nombre' => 'required',
            'dni' => 'required|numeric|unique:visitas',
            'itemsjson' => 'required'
        ],
        [
            'itemsjson.required' => 'Las selecciones de: entidad,empleados,oficinas,sedes y motivo no deben estar vacias'
        ]);
         if ($validator->fails()) {
           return response()->json(['error'=>$validator->errors()->all()],422);
        }else{
            if ($request->has('srcfoto')) {
                if (!empty($all['srcfoto'])) {
                
                    if(!Storage::disk('public_uploads')->has('Visitas')){
                        Storage::disk('public_uploads')->makeDirectory('Visitas');
                    }
                    $img = $all['srcfoto'];
                    $img = str_replace('data:image/png;base64,', '', $img);
                    $img = str_replace(' ', '+', $img);
                    $data = base64_decode($img);
                    $im = imagecreatefromstring($data);  //convertir text a imagen
                    if ($im !== false) {
                        imagejpeg($im, public_path().'/storage/Visitas/'.$all['dni'].time().'.jpg'); //guardar a server 

                        imagedestroy($im); //liberar memoria  
                        $all['srcfoto'] = $all['dni'].time().'.jpg';
                    }
                }
            }
            $all['fecha'] = now();
            $all['hora_entrada'] = date('h:i:s A');
            $all['itemsjson'] = json_encode($all['itemsjson']);
            $table = new Visita();


            $table->fill($all)->save();
            /*
            if ($request->has('herramienta')) {
               $herramienta = $request->all();
                if ($herramienta['herramienta'] != 'no') {                
                    for ($i=0; $i <count($herramienta['htrabajo']) ; $i++) { 
                        $this->table->nombre = $herramienta['htrabajo'][$i];
                        $this->table->marca = $herramienta['mtrabajo'][$i];
                        $this->table->serial = $herramienta['strabajo'][$i];
                        $this->table->insert_utilitarios();
                    }
                }
            }
            */
            $request->session()->flash('create', 'Registro con el nombre '.$all['nombre'].' agregado con exito!');
            return response()->json(['success'=>'Registro agregado con exito','url'=>url('visitas')]);
        }
    }

    public function marcar(Request $request){
       $datos = $request->all();
       $data = Visita::find($datos['id_data']);
        if (!empty($data)) {
           $data->hora_salida = date('h:i:s A');
           $data->save();
           return response()->json(['success'=>'Visita agregada con exito']);
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
    public function update(Request $request, $id)
    {
        //
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
        $visita = Visita::find($all['id_data']);
        if (!empty($visita)) {
            $visita->delete();
        }

    }
}
