<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    //esto conecta cada reserva con un usuario y cada reserva con un servicio
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
    public function service()
    {
        return $this->belongsTo(\App\Models\Service::class);
    }    
}
