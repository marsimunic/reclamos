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
use App\ViewDocumento;
use App\ViewReclamo;
use DB;

class ReclamosController extends Controller
{
    //
    public function getReclamos(Request $request)
  	{
  		// Get user of access token
        $user  =  Auth::user();
  		//Generamos objeto respuesta
  		$objReclamo = new ReclamoObject;
		$reclamos = ViewReclamo::all();
		$collectObjReclamos = collect([]);
  		foreach ($reclamos as $reclamo) 
  		{
  			$collectObjReclamos->push(new ReclamoResource($reclamo));
  		}
  		return  response()->json( [ 'success' => true, 'reclamos' => $collectObjReclamos]);
  	}
}
