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
use App\Models\Herramienta;
use App\Models\User;
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
            return '';
        })->addColumn('hora_salida', function($row){
            if (!empty($row['hora_salida'])) {
                return $row['hora_salida'];
            }
            return 0;
        })->addColumn('hora_entrada', function($row){
            if (!empty($row['hora_entrada'])) {
                return $row['hora_entrada'];
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
            'empleados'=>User::all(),
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
            'fecha_programada'=>'required',
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
            $all['itemsjson'] = json_encode($all['itemsjson']);
            $table = new Visita();

            //Validamos las fechas progamadas
            if(strtotime($all['fecha_programada']) > time()){
                $all['fecha_programada'] = $all['fecha_programada'];
                $all['type_visita'] = 2;
                $typeurl = url('visitaprogramada');
            }else{
                $all['hora_entrada'] = date('h:i:s A');
                $all['type_visita'] = 1;
                $typeurl = url('visitas');
            }
            
        
      

            $table->fill($all)->save();
            if ($all['herramientastatus'] == 'si') {  
                if (count($all['inputs']) > 0) {               
                    $visitalast = Visita::orderBy('id','DESC')->first();
                    foreach ($all['inputs'] as $key => $val) {
                        $herramienta = new Herramienta();
                        $herramienta->nombre = $val['value_herramienta'];
                        $herramienta->marca = $val['value_marca'];
                        $herramienta->serial = $val['value_serial'];
                        $herramienta->visita_id = $visitalast->id;
                        $herramienta->save();
                    }  
                }
            }
        
            $request->session()->flash('message_success', 'Registro con el nombre '.$all['nombre'].' agregado con exito!');
            return response()->json(['success'=>'Registro agregado con exito','url'=> $typeurl]);
        }
    }

    public function marcar(Request $request){
       $datos = $request->all();
       $data = Visita::find($datos['id_data']);
        if (!empty($data)) {
            if ($datos['type'] == 'entrada') {
                $data->hora_entrada = date('h:i:s A');
            }else{
                $data->hora_salida = date('h:i:s A');
            }
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
        $visita = new Visita();
        return $visita->mapvisitaById($id);
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
            'nombre' => 'required',
            //'dni' => 'required|numeric|unique:visitas',
            'itemsjson' => 'required',
            'fecha_programada'=>'required'

        ]);
        if ($validator->fails()) {
           return response()->json(['error'=>$validator->errors()->all()]);
        }else{
            $visita = Visita::find($all['id']);
            if ($request->has('src_foto')) {
              if(!Storage::disk('public_uploads')->has('Visitas')){
                  Storage::disk('public_uploads')->makeDirectory('Visitas');
              }
              if (Storage::disk('public_uploads')->exists('Visitas/'.$visita->srcfoto)) {
                  Storage::disk('public_uploads')->delete('Visitas/'.$visita->srcfoto);
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
     

            //Validamos las fechas progamadas
            if($all['fecha_programada'] > date('Y-m-d')){
                $all['fecha_programada'] = $all['fecha_programada'];
                $all['hora_entrada'] = null;
                $all['type_visita'] = 2;
            }else{
                $all['hora_entrada'] = date('h:i:s A');
                $all['type_visita'] = 1;
            }

            $visita->fill($all)->save();
            if ($all['herramientastatus'] == 'si') {  
                if (count($all['inputs']) > 0) {               
                    foreach ($all['inputs'] as $key => $val) {
                        $herramienta = new Herramienta();
                        $herramienta->nombre = $val['value_herramienta'];
                        $herramienta->marca = $val['value_marca'];
                        $herramienta->serial = $val['value_serial'];
                        $herramienta->visita_id = $all['id'];
                        $herramienta->save();
                    }  
                }
                if (count($all['herramientas']) > 0) {
                    foreach ($all['herramientas'] as $key => $val) {
                        $herramienta = Herramienta::find($val['id']);
                        $herramienta->nombre = $val['nombre'];
                        $herramienta->marca = $val['marca'];
                        $herramienta->serial = $val['serial'];
                        $herramienta->visita_id = $all['id'];
                        $herramienta->save();
                    }  
                }
            }

          $request->session()->flash('message_success', 'Registro actualizado con exito!');

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
        $all = $request->all();
        $visita = Visita::find($all['id_data']);
        if (!empty($visita)) {
            $visita->delete();
            Herramienta::where('visita_id',$visita->id)->delete();
        }

    }
}
