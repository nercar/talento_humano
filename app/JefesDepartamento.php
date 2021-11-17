<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JefesDepartamento extends Model
{
	protected $fillable = ['id', 'login', 'nombre', 'correo', 'activo'];
}
