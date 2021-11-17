<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
	protected $fillable = ['id', 'nombre', 'id_empresa', 'id_jefe', 'activo'];
}
