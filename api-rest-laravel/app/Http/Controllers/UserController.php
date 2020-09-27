<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

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
                'email'    => 'required|email|unique:users',
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

                //Cifrar contraseña
                //$encrypt_password = password_hash($params->password, PASSWORD_BCRYPT, ['cost' => 4]);
                $encrypt_password = hash('sha256', $params->password);

                //Crear usuario
                $user = new User();
                $user->name = $params_array['name'];
                $user->surname = $params_array['surname'];
                $user->email = $params_array['email'];
                $user->role = 'role_user';
                $user->password = $encrypt_password;
                $user->save();

                $data = [
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'User Saved',
                    'user' => $user
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
        
   }

   public function login(Request $request){
       
       $email = 'r3@m.com';
       $password = '9906';
       //$pwd = password_hash($password, PASSWORD_BCRYPT, ['cost' => 4]);
       $pwd = hash('sha256', $password);
       
       $jwtAuth = new \JwtAuth();

       return response()->json($jwtAuth->signUp($email, $pwd, true));
   }
    
}
