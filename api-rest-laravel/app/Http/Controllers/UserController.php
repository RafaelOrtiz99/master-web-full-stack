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
        
    
        if(!empty($params) && !empty($params_array)){

            //Limpiar datos
            $params_array = array_map('trim', $params_array);

            //Validar datos
            $validate = \Validator::make($params_array,[
                'name'     => 'required|alpha',
                'surname'  => 'required|alpha',
                'email'    => 'required|email',
                'password' => 'required',
            ]);

            if($validate->fails()){
                $data = [
                    'status'  => 'error',
                    'code'    => '404',
                    'message' => 'User not created'
                    ,'errors' => $validate->errors()
                ];
                return response()->json($data, 400);
            }
            else{
                $data = [
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'User Saved'
                ];
            }
        }
        else{
            $data = [
                'status'  => 'error',
                'code'    => '404',
                'message' => 'Incorrect data',
            ];

        }

        return response()->json($data, $data['code']);
        
        //Cifrar contraseña

        //Comprobar si el usuario existe

        //Crear usuario

       return response()->json($data, $data['code']);
   }

   public function login(Request $request){
        return "Login";
   }
    
}
