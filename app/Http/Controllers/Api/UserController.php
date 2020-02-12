<?php

namespace App\Http\Controllers\Api;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $successStatus  =   200;
 
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
        //if (Auth::guard('api')->check()) {
            // Here you have access to $request->user() method that
            // contains the model of the currently authenticated user.
            //
            // Note that this method should only work if you call it
            // after an Auth::check(), because the user is set in the
            // request object by the auth component after a successful
            // authentication check/retrival
          //  return response()->json($request->user());
        //}
        if (Auth::check()) 
        {
            //$token                  =       $user->getToken('token')->accessToken;
            $success['success']     =       true;
            $success['message']     =       "La session ya se encuentra iniciada.";
           // $success['token']       =       $token;
            return response()->json(['success' => $success ], $this->successStatus);

        }
        if(Auth::attempt(['email' => request('usuario'), 'password' => request('password')])) 
        {
             
            // getting auth user after auth login
            $user = Auth::user();
 
            $token                  =       $user->createToken('token')->accessToken;
            $success['success']     =       true;
            $success['message']     =       "Inicio de sesión correcto.";
            $success['token']       =       $token;
            $success['token_type']  =       'Bearer';
 
            return response()->json(['success' => $success ], $this->successStatus);
        }
 
        else {
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }
    public function userLogout(Request $request)
    {

            $request->user()->token()->revoke();
            return response()->json([
            'message' => 'Sesión finalizada.',
            "status" => 200 
            ]);
    }
}
