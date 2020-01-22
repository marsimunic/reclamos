<?php

namespace App\Http\Resources;

use App\Http\Resources\DocumentoResource;
//use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ReclamoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'EMPRESA' => $this->empresa,
            'COD_RECL' => $this->cod_recl,
            'SUMINISTRO' => $this->suministro,
            'MOTIVO' => $this->motivo,
            'COD_MOT' => $this->cod_mot,
            'FE_HO_REC' => $this->fe_ho_rec,
            'PELIGRO' => $this->peligro,
            'OBSERVAC' => $this->observac,
            //'DOCUMENTO' => $this->documento,
            'DOCUMENTO' => $this->viewDocumento,
        ];
    }
}
