<?php

namespace Crudly\Encrypted;

use Illuminate\Contracts\Database\Eloquent\CastsInboundAttributes;
use Illuminate\Support\Facades\Hash;

class Password implements CastsInboundAttributes
{
	/**
	 * Prepare the given value for storage.
	 *
	 * @param  \Illuminate\Database\Eloquent\Model  $model
	 * @param  array  $value
	 */
	public function set($model, string $key, $value, array $attributes): string
	{
		return Hash::make($value);
	}
}
