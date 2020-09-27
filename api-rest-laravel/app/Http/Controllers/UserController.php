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

        $jwtAuth = new \JwtAuth();

        //Recibir datos por POST
        $json = $request->input('json', null);
        $params = json_decode($json);
        $params_array = json_decode($json, true);

        //Validar datos
        $validate = \Validator::make($params_array,[
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        if($validate->fails()){
            $signUp = [
                'status' => 'error',
                'code' => 404,
                'message' => 'Authentication Failed',
                'errors' => $validate->errors()
            ];
        }
        else{

            //Cifrar password
            //$pwd = password_hash($password, PASSWORD_BCRYPT, ['cost' => 4]);
            $pwd = hash('sha256', $params->password);
            $signUp = $jwtAuth->signUp($params->email, $pwd);

            if(!empty($params->getTSoken)){
                $signUp = $jwtAuth->signUp($params->email, $pwd, true);
            }
        }

        //Devolver token o datos
        return response()->json($signUp,200);

   }

   public function update(Request $request){
       $token = $request->header('Auth');

       $jwtAuth = new \JwtAuth();
       $checkToken = $jwtAuth->checkToken($token);

       if($checkToken){
           echo "<h1>Login Correcto</h1>";
       }
       else{
        echo "<h1>Login Incorrecto</h1>";
       }
       die();
   }
    
}
