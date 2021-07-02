<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visita extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'dni',
        'motivo',
        'lugar',
        'fecha',
        'hora_entrada',
        'hora_salida',
        'srcfoto',
        'itemsjson'
    ];
    /*Map para visitas de este modo sacamos  el nombre de las variables que estan como tipo json, sea entiendad,motivo, oficina,empleados*/
    public function mapvisita($request){
        $collect =  Visita::all();
        if (!empty($request->input('fechadesde')) OR !empty($request->input('fechahasta'))) {
            $fechadesde = $request->input('fechadesde');
            $fechahasta = $request->input('fechahasta');
            $collect = Visita::whereBetween('fecha',array($fechadesde,$fechahasta))->get(); 
        }
        $collect->map(function($item, $key) {
            if (!empty($item->itemsjson)) {
            
                $json = json_decode($item->itemsjson);
                foreach ($json as $key => $val) {
                    $item->$key = $val->name;
                }
            }
        });
        return $collect;
    }
}
