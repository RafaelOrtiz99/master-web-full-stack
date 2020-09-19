<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
   public function register(Request $request){

        //Obtener datos

        /*
         * 1. Se obtienen los datos
         * 2. Decodificar los datos
         * 
         */
        $json = $request->input('json', null);
        $params = json_decode($json); //objeto
        $params_array = json_decode($json,true); //array       

        //Validar datos

        //Cifrar contraseña

        //Comprobar si el usuario existe

        //Crear usuario

       $data = [
           'status' => 'error',
           'code' => '404',
           'message' => 'User not created'
       ];

       return response()->json($data, $data['code']);
   }

   public function login(Request $request){
        return "Login";
   }
    
}
