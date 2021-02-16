<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\registerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginRegister extends Controller
{
    /**
     * Login
     */
    public function login()
    {
        return view('login');
    }


    /**
     * Logout
     */
    public function logout() {
        session()->flush();
        Auth::logout();
        session()->forget(['usuario']);
        return redirect('/');
    }

    /**
     * Validacion login.
     */
    public function recibirlogin(Request $request) {
        // Recibir los datos del formulario con el request.
        $datos = $request->except('_token','Entrar');
        $email = $request->email;

        // Verificamos que existe el usuario con los datos aportados
        $pasa = DB::table('usuarios')->where([
            ['correo', '=', $datos['email']], 
            ['contra', '=', $datos['password']]
            ])->count();

        // Recogemos todos los datos del admin con los datos aportados
        $result = DB::table('usuarios')->where([
            ['correo', '=', $datos['email']], 
            ['contra', '=', $datos['password']]
            ])->first();
        
        // $rol = DB::select('SELECT *
        // FROM usuarios
        // WHERE usuarios.correo = ?', [$email]);
        
        // Si existe el admin, la variable $pasa valdrá 1, entonces entrar en el if
        // de lo contrario pasa por el else y nos redirige al login
        
        if ($pasa > 0) {
            // Establecer sesion y redirigir a la pagina mostrar.
            // if ($result[0]->rol == 'admin') {
            //     // Establecer sesion y redirigir a la pagina mostrar.
                session()->put('usuario', $result);
                return redirect('home');
            // }elseif ($result[0]->rol == 'user') {
            //     // Establecer sesion y redirigir a la pagina mostrar.
            //     session()->put('email_usuario', $request->email);
            //     return redirect('home2');
            // }else {
            //     // Redirigir al login
            //     return redirect('/');
            // }
        }else {
            // Redirigir al login
            return redirect('/');
        }
    }

    /**
     * Recibe los datos del formulario para crear un nuevo usuario
     */
    public function recibir(registerRequest $request) {
        // Recogemos todos los datos enviados menos el token y el boton 'Registrar'
        $datos=$request->except('Registrar');
        
        // Creamos el alumno en la DB.
        DB::table('usuarios')->insertGetId(['nombre'=>$datos['usernameRegister'],'correo'=>$datos['emailRegister']
        ,'contra'=>$datos['passwordRegister'], 'rol'=>'user']);

        // Una vez creado el alumno hacemos una redireccion a mostrar.
        return redirect('home');
    }
}
