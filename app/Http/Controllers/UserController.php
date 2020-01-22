<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $successStatus  =   200;
 
    //----------------- [ Register user ] -------------------
    public function registerUser(Request $request) 
    {
 
        $validator  =   Validator::make($request->all(),
            [
                'name'              =>      'required|min:3',
                'email'             =>      'required|alpha_num|min:8',
                'password'          =>      'required|alpha_num|min:5',
                'confirm_password'  =>      'required|same:password'
            ]
        );
 
        if($validator->fails()) {
            return response()->json(['Validation errors' => $validator->errors()]);
        }
 
        $input              =       array(
            'name'          =>          $request->name,
            'email'         =>          $request->email,
            'password'      =>          bcrypt($request->password),
            'address'       =>          $request->address, 
            'city'          =>          $request->city
        );
 
        // check if email already registered
        $user = User::where('email', $request->email)->first();
        if(!is_null($user)) {
            $data['message'] = "El usuario no se encuentra registrado.";
            return response()->json(['success' => false, 'status' => 'failed', 'data' => $data]);
        }
 
        // create and return data
        $user =  User::create($input);         
        $success['message'] = "Usuario registrado.";
 
        return response()->json( [ 'success' => true, 'user' => $user ] );
    }
    // -------------- [ User Login ] -----------------
    public function userLogin(Request $request) {

    	return response()->json(['error'=>$request], 401);
    	/*if (Auth::check()) 
    	{
    		$token                  =       $user->getToken('token')->accessToken;
            $success['success']     =       true;
            $success['message']     =       "La session ya se encuentra iniciada.";
            $success['token']       =       $token;
            return response()->json(['success' => $success ], $this->successStatus);

		}
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])) 
        {
             
            // getting auth user after auth login
            $user = Auth::user();
            $token                  =       $user->createToken('token')->accessToken;
            $success['success']     =       true;
            $success['message']     =       "Inicio de sesión correcto.";
            $success['token']       =       $token;
 
            return response()->json(['success' => $success ], $this->successStatus);
        }
        else {
            return response()->json(['error'=>'Unauthorised'], 401);
        }*/
    }
}
