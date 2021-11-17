<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
	protected $fillable = ['nombre', 'fecha', 'id_tipo', 'id_empresa', 'estado', 'suspender', 'tiempo', 'origen', 'orador'];
}
