<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use Illuminate\Support\Facades\DB;

use App\Models\User;

class JwtAuth{

    private $key;

    public function __construct() {
        $this->key = 'This_Is_A_Key-99999';
    }

    public function signUp($email, $password, $getToken = null){

        //Buscar si existe el usuario con las credenciales
        $user = User::where([
            ['email', $email],
            ['password', $password]
        ])->first();

        $signUp = is_object($user) ? true : false; 

        //Comprobar si son correctas
        if($signUp){
            $token = array(
                'sub'     => $user->id,
                'email'   => $user->email,
                'name'    => $user->name,
                'surname' => $user->surname,
                'iat'     => time(),
                'exp'     => time() + (7 * 24 * 60 * 60) //días, horas, minutos, segundos, caducación de token a una semana
            );

            // Generar token con los datos del usuario
            $jwt = JWT::encode($token, $this->key, 'HS256');
            $decode = JWT::decode($jwt, $this->key, ['HS256']); 

            //Devolver los datos decodificadoso el token en función de un parámetro
            $data = is_null($getToken) ? $jwt : $decode;
        }
        else{
            $data = array(
                'status'  => 'error',
                'message' => 'incorrect login'
            );
        }
        return $data;
    }

    public function checkToken($jwt, $getIdentity = false){
        $auth = false;

        try{
            $jwt = str_replace('"','', $jwt);
            $decode = JWT::decode($jwt, $this->key, ['HS256']);
        }
        catch(\UnexpectedValueException $e){$auth = false;}
        catch(\DomainException $e){$auth = false;}

        $auth = !empty($decode) && is_object($decode) && isset($decode->sub) ? true : false;

        if($getIdentity) return $decode;

        return $auth;
    }


}