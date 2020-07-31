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
	 * @param  string|null  $castType
	 * @return void
	 */
	public function __construct(string $castType = null)
	{
		$this->castType = $castType === 'null' ? null : $castType;

		if ($this->castType)
			$this->caster = new Caster($castType);
	}

	/**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function get($model, string $key, $value, array $attributes)
	{
		if (!is_null($value))
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
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return string
     */
    public function set($model, string $key, $value, array $attributes)
	{
		return encrypt($value);
	}
}
