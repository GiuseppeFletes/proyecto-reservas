<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

//esto dice que un servicio puede tener muchas reservas
public function reservations()
{
    return $this->hasMany(\App\Models\Reservation::class);
}    
}
