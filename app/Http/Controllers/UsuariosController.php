<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\crearRestRequest;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\modificarRestRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mail\Email;

class UsuariosController extends Controller
{

    public function home(){
        // En el caso de que no se haya inicializado la sesión te redirige al login
        if(!(session()->has('usuario'))) {
            return redirect('/');
        }

        return view('home');
    }


    public function mostrar(Request $request){
        // En el caso de que no se haya inicializado la sesión te redirige al login
        if (!(session()->has('usuario'))) {
            return redirect('/');
        }
        $filtro = $request->input('filtro');
        $filtro2 = $request->input('filtro2');
        // Recogemos todos los datos de la tabla restaurantes
        // $lista=DB::table('restaurante')->get();
        if ($filtro == "" && $filtro2 == "") {
            $lista = DB::select('SELECT restaurante.*, tipo.tipo_cocina, ubicacion.*, mg.*
            FROM restaurante 
                LEFT JOIN tipo ON restaurante.id_tipo = tipo.id_tipo 
                LEFT JOIN ubicacion ON restaurante.id_ubicacion = ubicacion.id_ubicacion
                LEFT JOIN mg ON restaurante.id_restaurante = mg.id_restauranteMg
                WHERE restaurante.estado = "1"');
                // GROUP BY restaurante.id_restaurante
        } else {
            $lista = DB::select('SELECT restaurante.*, tipo.tipo_cocina, ubicacion.*, mg.*
            FROM restaurante 
            LEFT JOIN tipo ON restaurante.id_tipo = tipo.id_tipo 
            LEFT JOIN ubicacion ON restaurante.id_ubicacion = ubicacion.id_ubicacion
            LEFT JOIN mg ON restaurante.id_restaurante = mg.id_restauranteMg
            WHERE tipo.tipo_cocina LIKE ?
            AND restaurante.precio_medio LIKE ?
            AND restaurante.estado = "1"',["%".$filtro."%", "%".$filtro2."%"]);
        }
        
        // Seteamos valor a la foto con base64_encode
        foreach ($lista as $i ) {
            if ($i->foto !=null) {
                $i->foto = base64_encode($i->foto);
            }
        }

        // Retorna la vista mostrar con los datos de la variable lista
        return response()->json($lista ,200);
    }

    public function modificar($id) {
        //Declaramos la query
        $query = "SELECT restaurante.*, ubicacion.*, tipo.* 
        FROM restaurante 
        INNER JOIN ubicacion ON restaurante.id_ubicacion = ubicacion.id_ubicacion 
        INNER JOIN tipo ON restaurante.id_tipo = tipo.id_tipo
        WHERE restaurante.id_restaurante = " .  $id;
        //Recogemos un restaurante de la BD, especificando el id
        $restaurante = DB::select($query)[0];
        //Enviamos los datos obtenidos a la vista actualizar
        return view('modificar', compact('restaurante'));
    }

    /**
     * Actuliza el usuario especificado por el parametro de entrada (id).
     */
    public function actualizar(modificarRestRequest $request, $id) {
        // Recibir los datos del formulario con el request.
        $datos = $request->except('Enviar','_method');

        // Select de los campos que queremos actualizar
        $restaurante = DB::table('restaurante')->where('id_restaurante', $id)->first();

        //Actualizar la bd con los datos recibidos.
        DB::table('ubicacion')->where('id_ubicacion','=',$restaurante->id_ubicacion)->update(['cp'=>$datos['cp'],'calle'=>$datos['calle'],'ciudad'=>$datos['ciudad']]);
        
        //Depende de si el usuario ha seleccionado una imagen nueva o no, ejecuta una query u otra
        if(isset($datos['img'])) {
            // Pasamos la imagen a la variable $img
            $img = $request->file('img')->getRealPath();
            //Traemos el contenido del fichero $img
            $bin = file_get_contents($img);

            DB::table('restaurante')->where('id_restaurante','=',$id)->update(['nombre'=>$datos['nombre'],'id_tipo'=>$datos['tipoCocina'],'precio_medio'=>$datos['precio_medio'],'correo'=>$datos['correo'],'foto'=>$bin]);
        } else {
            DB::table('restaurante')->where('id_restaurante','=',$id)->update(['nombre'=>$datos['nombre'],'id_tipo'=>$datos['tipoCocina'],'precio_medio'=>$datos['precio_medio'],'correo'=>$datos['correo']]);
        }

        $asunto = "Estimado cliente su restaurante ha sido actualizado";
        $mensaje = "Estimado cliente, gracias por confiar en ElTenedor. Le informamos que su restaurante ha sido modificado. Un saludo";
        $email=array(
            // 'name' => $request->input('name'),
            // 'content' => $request->input('content')
            'name'=>$asunto,
            'content'=>$mensaje
        );

        $correo=$datos['correo'];

        Mail::to($correo)->send(new Email($email));

        //Redirigir a mostrar
        return redirect('home');
    }

    /**
     * Da de baja el restaurante especificado por el parametro de entrada.
     */
    public function baja($id) {
        //Eliminamos un empleado de la BD, especificando el id
        DB::table('restaurante')->where('id_restaurante', "=", $id)->update(array('estado'=>'0'));
        //Volvemos a la vista mostrar
        return redirect('home');
    }

    /**
     * Redirige a la vista donde puedes crear un nuevo restaurante.
     */
    public function crear() {
        return view('crear');
    }

    /**
     * Recibe los datos del formulario para crear un nuevo empleado
     */
    public function crearRestaurante(crearRestRequest $request) {
        // Recogemos todos los datos enviados menos el token y el boton 'Enviar'
        $datos=$request->except('Enviar');
        
        // Creamos la ubicacion en la DB.
        DB::table('ubicacion')->insertGetId(['cp'=>$datos['cp'],'calle'=>$datos['calle']
        ,'ciudad'=>$datos['ciudad']]);

        // Recuperamos el id de la ubicacion
        $lastID = DB::getPdo()->lastInsertId();;

        // Pasamos la imagen a la variable $img
        $img = $request->file('img')->getRealPath();
        //Traemos el contenido del fichero $img
        $bin = file_get_contents($img);

        // Creamos el restaurante en la DB.
        DB::table('restaurante')->insertGetId(['nombre'=>$datos['nombre'],'id_ubicacion'=>$lastID
        ,'id_tipo'=>$datos['tipoCocina'],'precio_medio'=>$datos['precio_medio'],'correo'=>$datos['correo']
        ,'foto'=>$bin]);

        // Una vez creado el alumno hacemos una redireccion a mostrar.
        return redirect('home');
    }

    public function baja_restaurante(){
        return view('baja');
    }

    public function mostrarbaja(Request $request){
        // En el caso de que no se haya inicializado la sesión te redirige al login
        if(!(session()->has('usuario'))) {
            return redirect('/');
        }
        $filtro = $request->input('filtro');
        $filtro2 = $request->input('filtro2');
        // Recogemos todos los datos de la tabla restaurantes
        // $lista=DB::table('restaurante')->get();
        if ($filtro == "" && $filtro2 == "") {
            $lista = DB::select('SELECT restaurante.*, tipo.tipo_cocina, ubicacion.*
            FROM restaurante 
                INNER JOIN tipo ON restaurante.id_tipo = tipo.id_tipo 
                INNER JOIN ubicacion ON restaurante.id_ubicacion = ubicacion.id_ubicacion
                WHERE restaurante.estado = "0"');
        } else {
            $lista = DB::select('SELECT restaurante.*, tipo.tipo_cocina, ubicacion.*
            FROM restaurante 
            INNER JOIN tipo ON restaurante.id_tipo = tipo.id_tipo 
            INNER JOIN ubicacion ON restaurante.id_ubicacion = ubicacion.id_ubicacion
            WHERE tipo.tipo_cocina LIKE ?
            AND restaurante.precio_medio LIKE ?
            AND restaurante.estado = "0"',["%".$filtro."%", "%".$filtro2."%"]);
        }
        
        
        // Seteamos valor a la foto con base64_encode
        foreach ($lista as $i ) {
            if ($i->foto !=null) {
                $i->foto = base64_encode($i->foto);
            }
        }

        // Retorna la vista mostrar con los datos de la variable lista
        return response()->json($lista ,200);
    }

    public function alta($id) {
        //Eliminamos un empleado de la BD, especificando el id
        DB::table('restaurante')->where('id_restaurante', "=", $id)->update(array('estado'=>'1'));
        //Volvemos a la vista mostrar
        return redirect('baja_restaurante');
    }

    // MG
    public function mg($id_restaurante, Request $request) {
        // Recogemos todos los datos enviados menos el token y el boton 'Enviar'
        $datos=$request->except('Enviar');

        // Creamos la ubicacion en la DB.
        DB::table('mg')->insertGetId(['id_restauranteMg'=>$id_restaurante,'id_usuarioMg'=>$datos['id_usuario']]);

        return redirect("home");
    }

    // delete MG
    public function deleteMg($id_restaurante, Request $request) {
        // Recogemos todos los datos enviados menos el token y el boton 'Enviar'
        $datos=$request->except('Enviar');

        // Creamos la ubicacion en la DB.
        DB::table('mg')->where('id_restauranteMg', "=", $id_restaurante)->where('id_usuarioMg', "=", $datos['id_usuario'])->delete();

        return redirect("home");
    }
}
