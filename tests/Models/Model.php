<?php

namespace Crudly\Encrypted\Tests\Models;

use Crudly\Encrypted\Encrypted;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Model extends Eloquent
{
	protected $casts = [
		'column' => Encrypted::class,

		'integer_int' => Encrypted::class.':int',
		'integer_integer' => Encrypted::class.':integer',

		'float_real' => Encrypted::class.':real',
		'float_float' => Encrypted::class.':float',
		'float_double' => Encrypted::class.':double',

		'decimal_2' => Encrypted::class.':decimal:2',
		'decimal_4' => Encrypted::class.':decimal:4',

		'string' => Encrypted::class.':string',

		'bool_bool' => Encrypted::class.':bool',
		'bool_boolean' => Encrypted::class.':boolean',

		'object' => Encrypted::class.':object',

		'array_array' => Encrypted::class.':array',
		'array_json' => Encrypted::class.':json',

		'date_date' => Encrypted::class.':date',

		'datetime_datetime' => Encrypted::class.':datetime',
		'datetime_custom_datetime' => Encrypted::class.':custom_datetime',

		'timestamp' => Encrypted::class.':timestamp',
	];
}