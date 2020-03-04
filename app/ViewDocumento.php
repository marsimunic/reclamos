<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViewDocumento extends Model
{
    // 
    protected $connection = 'oracle';
    protected $table = 'sistrans.V_EPRE_CANAL_REC_ABIERTOS_DOC';
    //protected $primaryKey = 'documento';
    //protected $fillable = ['documento'];
     //
    /*public function viewReclamo()
    {
      return $this->hasMany('App\ViewReclamo');
      return $this->belongsTo('App\ViewReclamo');
    }*/
}
