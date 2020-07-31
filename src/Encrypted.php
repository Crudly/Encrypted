<?php

namespace Crudly\Encrypted;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Encrypted implements CastsAttributes
{
	/**
	 * The type for coercion.
	 *
	 * @var string
	 */
	protected $castType;

	/**
	 * Caster that coerces types.
	 *
	 * @var Crudly\Encrypted\Caster
	 */
	protected $caster;

	/**
	 * Create a new cast class instance.
	 *
	 * @return void
	 */
	public function __construct(string $castType = null)
	{
		$this->castType = 'null' === $castType ? null : $castType;

		if ($this->castType)
			$this->caster = new Caster($castType);
	}

	/**
	 * Cast the given value.
	 *
	 * @param  \Illuminate\Database\Eloquent\Model  $model
	 * @param  mixed  $value
	 *
	 * @return mixed
	 */
	public function get($model, string $key, $value, array $attributes)
	{
		if (null !== $value)
			$value = decrypt($value);

		if (!$this->castType)
			return $value;

		$this->caster->setModel($model);

		return $this->caster->coerce($value);
	}

	/**
	 * Prepare the given value for storage.
	 *
	 * @param  \Illuminate\Database\Eloquent\Model  $model
	 * @param  mixed  $value
	 *
	 * @return string
	 */
	public function set($model, string $key, $value, array $attributes)
	{
		return encrypt($value);
	}
}
