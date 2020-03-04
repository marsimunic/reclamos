<?php

namespace App\Http\Controllers\Api;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    private $successStatus   =  200;
    private $unsuccessStatus =  401;
 
    //----------------- [ Register user ] -------------------
    public function userRegister(Request $request) 
    {
 
        $validator  =   Validator::make($request->all(),
            [
                'name'              =>      'required|min:3',
                'usuario'           =>      'required|alpha_num|min:8',
                'password'          =>      'required|alpha_num|min:5',
                'confirm_password'  =>      'required|same:password'
            ]
        );
 
        if($validator->fails()) {
            return response()->json(['Validation errors' => $validator->errors()]);
        }
 
        $input              =       array(
            'name'          =>          $request->name,
            'email'         =>          $request->usuario,
            'password'      =>          bcrypt($request->password),
            'address'       =>          $request->address, 
            'city'          =>          $request->city
        );
 
        // check if email already registered
        $user = User::where('email', $request->usuario)->first();
        if(!is_null($user)) {
            $data['message'] = "El usuario ya se encuentra registrado.";
            return response()->json(['success' => false, 'status' => 'failed', 'data' => $data]);
        }
 
        // create and return data
        $user =  User::create($input);         
        $success['message'] = "Usuario registrado.";
 
        return response()->json( [ 'success' => true, 'user' => $user ] );
    }
    // -------------- [ User Login ] -----------------
    public function userLogin(Request $request) {
        
        $usuario = $request->header('usuario');
        $password = $request->header('password');
        
        if(Auth::attempt(['email' => $usuario, 'password' => $password])) 
        {
            // getting auth user after auth login
            $user = Auth::user();
            $token                  =       $user->createToken('token')->accessToken;
            $success['success']     =       true;
            $success['status']      =       $this->successStatus;
            $success['message']     =       "Token Generated.";
            $success['token']       =       $token;
            $success['token_type']  =       'Bearer';
        }
        else 
        {
            $success['success']     =       false;
            $success['status']      =       $this->unsuccessStatus;
            $success['message']     =       "User or Password is incorrect.";
        }
        return response()->json(['acceso' => $success ], $this->successStatus);
    }
    public function userLogout(Request $request)
    {
        //Revocamos el token
        try {
            $request->user()->token()->revoke();
        }
        catch (\Exception $e)
        {
            // Almacenamos la información del error.
            Log::error('MSI-Revocar-Token-: ' . $e->getMessage());
            //Devolvemos los datos de error
            $success['success'] = false;
            $success['status']  = $this->successStatus;
            $success['message'] = "Error inesperado.";
            return response()->json(['logout' => $success],$this->successStatus);
        }
        //Devolvemos los datos de error.
        $success['success'] = true;
        $success['status']  = $this->successStatus;
        $success['message'] = "Sesión finalizada.";
        return response()->json(['logout' => $success],$this->successStatus);
    }
}
