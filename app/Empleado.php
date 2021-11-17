<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
	protected $fillable = ['id', 'apellido', 'nombre', 'id_cargo', 'id_departamento', 'id_empresa'];
}
