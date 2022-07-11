<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// GH - https://github.com/exegeses/laravel-57749

Route::get('/', function () {
    return view('welcome');
});

Route::get('/saludo',function(){
     return view('hola');
});

Route::get('/form',function(){
    return view('form');
});

Route::post('/procesa',function(request $request){
    $nombre =$request->nombre;
    $users=['admin','supervisor','operador','invitado'];
    return view('procesa',['nombre'=>$nombre,'users'=>$users]);
});

// pasar param 

Route::get('/param/{a}/{b}',function($a,$b){
    return 'parametro1: '.$a.'/'.$b;
});

// desde la plantilla 

Route::get('/inicio', function(){
    return view('inicio');
});

// Crud de regiiones //
Route::get('/regiones', function(){
    // obtenemos listado de regiones
    // DB es un facade , una clase que podemos acceder a ella y  ahorrar codigo que esta x detras
    //$regiones= DB::select('SELECT idRegion,regNombre FROM regiones');
    // Query Builder
    $regiones = DB::table('regiones')->get();
    // pasamos datos a la vista
    return view('regiones',compact('regiones'));
});

Route::get("/region/create",function(){
     return view('regionCreate');
});

Route::post("/region/store",function(request $request){
     $nombre = $request->regNombre;
     //dd($nombre);
     // RAW SQL
    // DB::insert("insert into regiones (regNombre) values (?)",[$nombre]);
     // Query Builder = arma el sql , bindea parametros
     try {
             DB::table('regiones')->insert(['regNombre'=>$nombre]);
            // El with retorna variables de sesion ( llamadas flasing) que desaparecen al refrescar la pantalla
            return redirect('/regiones')->with(['mensaje'=>'region:'.$nombre.'agregada correctamente']);
        }catch(\Throwable $th) {
            return redirect('/regiones')->with(['mensaje' => 'Error No se pudo Crear'.$th->getMessage()]);
        } 
});
Route::get("/region/edit/{id}",function($id){
    // Bindeo el resultado
    // $region=DB::select("select idRegion, regNombre from regiones where idRegion = ?",[$id]);
    // Query Builder 
     $region=DB::table('regiones')->where('idRegion',"=", $id)->first();
    //dd($region);
    return view('regionEdit',['region'=>$region]);
});
Route::post('/region/update', function(){

    $regNombre = request()->regNombre;
    $idRegion = request()->idRegion;
    // DB::update('UPDATE regiones 
    //                  SET regNombre = :regNombre
    //                  WHERE idRegion = :idRegion', [$regNombre,$idRegion]);
    /* QUERY BUILDER
    DB::table('regiones')
                        ->where('idRegion',$idRegion)
                        ->update(['regNombre',$idRegion]);

    return redirect('regiones')->with(['mensaje'=>'Region: '.$regNombre.'modificada Correctamente']);  */
    try {
        // podemos forzar el error cambiando el nombre de algun campo
        DB::table('regiones')->where('idRegion',$idRegion)
                            ->update( [ 'regNombre' => $regNombre ] );

        return redirect('/regiones')->with(['mensaje' => 'Region: '.$regNombre.' Región modificada correctamente']);
    } catch (\Throwable $th) {
        //throw $th;
        return redirect('/regiones')->with(['mensaje' => 'Error No se pudo modificar']);
    }
                  

});
Route::get('/region/delete/{id}', function($id){
 
    $region = DB::table('regiones')->where('idRegion',$id)->first();
    return view('regionDelete', ['region'=>$region]);

});