<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Resources\ReclamoResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\ViewDocumento;
use App\ViewReclamo;
use DB;


class ReclamosController extends Controller
{
    private $successStatus   =  200;
    private $unsuccessStatus =  401;

    //Obtenemos todos los reclamos abiertos
    public function getReclamos(Request $request)
  	{
  		//Obtenemos el usuario del token
      $user  =  Auth::user();
      //Generamos objeto respuesta
  		$objReclamo = new ReclamoObject;
      try {
        // La variable no existe
         $reclamos = ViewReclamo::all();
      } catch (\Exception $e) {
          // Almacenamos la información del error.
          Log::error('MSI-Consulta-Reclamos: ' . $e->getMessage());
          $success['success'] = false;
          $success['status']  = $this->successStatus;
          return  response()->json( [ 'reclamos' => $success], $this->successStatus);
      }
      $collectObjReclamos = collect([]);
      foreach ($reclamos as $reclamo) 
  		{
  			$collectObjReclamos->push(new ReclamoResource($reclamo));
  		}
  		return  response()->json( [ 'success' => true, 'status'=> $this->successStatus,'reclamos' => $collectObjReclamos]);
  	}
}
