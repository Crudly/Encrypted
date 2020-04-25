<?php

namespace Crudly\Encrypted\Tests\Models;

use Crudly\Encrypted\Encrypted;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Model extends Eloquent
{
	protected $casts = [
		'column' => Encrypted::class,
	];
}