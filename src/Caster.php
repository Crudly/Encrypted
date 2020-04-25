<?php

namespace Crudly\Encrypted;

use Illuminate\Database\Eloquent\Concerns\HasAttributes;

class Caster
{
	use HasAttributes;

	/**
	 * The type for coercion.
	 *
	 * @var string
	 */
    protected $castType;

    /**
	 * Create a new cast class instance.
	 *
	 * @param  string|null  $castType
	 * @return void
	 */
	public function __construct(string $castType)
	{
		$this->castType = $castType;
	}

    /**
 	 * Coerce value to type.
 	 *
	 * @param  mixed  $value
	 * @return mixed
	 */
	public function coerce($value)
	{
		// Don't specify key, we override getCastType to provide correct type.
		return $this->castAttribute(null, $value);
	}

	/**
     * Get the type of cast. Used by HasAttributes::castAttribute
     *
     * @return string
     */
	protected function getCastType()
	{
		return $this->castType;
	}

	/**
     * Tell HasAttributes:castAttribute that we don't use further casting classes.
	 * Might allow in the future if there are some use cases.
     *
     * @return bool
     */
    protected function isClassCastable()
    {
        return false;
    }
}