<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViewReclamo extends Model
{
    protected $connection = 'oracle';
    protected $table = 'sistrans.V_EPRE_CANAL_REC_ABIERTOS';
    //protected $primaryKey = 'cod_recl';
    public function viewDocumento()
    {
      return $this->belongsTo('App\ViewDocumento','documento','documento');
    }
}
