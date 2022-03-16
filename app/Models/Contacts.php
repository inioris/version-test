<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    use HasFactory;

    protected $table = "Contactos";

    protected $primaryKey = 'IdContacto';

    public $timestamps = false;

    protected $fillable = [
       'Nombre',
       'Apellido',
    ];
}
