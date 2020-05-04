<?php

namespace Crudly\Encrypted;

use Illuminate\Contracts\Database\Eloquent\CastsInboundAttributes;
use Hash;

class Password implements CastsInboundAttributes
{
    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  array  $value
     * @param  array  $attributes
     * @return string
     */
    public function set($model, string $key, $value, array $attributes)
	{
		return Hash::make($value);
	}
}
