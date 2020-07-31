<?php

namespace Crudly\Encrypted;

use Illuminate\Support\Collection;
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
	 * The model whose properties we are casting.
	 *
	 * @var \Illuminate\Database\Eloquent\Model 
	 */
	protected $model;

	/**
	 * Create a new cast class instance.
	 *
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
	 *
	 * @return mixed
	 */
	public function coerce($value)
	{
		if (!\is_string($value))
		{
			if (\in_array($this->castType, ['array', 'json']))
				return (array) $value;

			if ('collection' == $this->castType)
				return $value instanceof Collection ? $value : collect($value);

			if ('object' == $this->castType)
				return (object) $value;

			if (\in_array($this->castType, ['date', 'datetime']) && \is_object($value))
				return (object) $value;
		}

		// Don't specify key, we override getCastType to provide correct type.
		return $this->castAttribute(null, $value);
	}

	/**
	 * Get the type of cast. Used by HasAttributes::castAttribute.
	 */
	protected function getCastType(): string
	{
		if ($this->isCustomDateTimeCast($this->castType))
			return 'custom_datetime';

		if ($this->isDecimalCast($this->castType))
			return 'decimal';

		return trim(strtolower($this->castType));
	}

	/**
	 * Tell HasAttributes::castAttribute that we don't use further casting classes.
	 * Might allow in the future if there are some use cases.
	 */
	protected function isClassCastable(): bool
	{
		return false;
	}

	/**
	 * Scam the casts array for HasAttributes::castAttribute.
	 */
	public function getCasts(): array
	{
		return [null => $this->castType];
	}

	/**
	 * Set the model property.
	 */
	public function setModel(\Illuminate\Database\Eloquent\Model $model): void
	{
		$this->model = $model;
	}

	/**
	 * Get the format for dates from the model.
	 */
	public function getDateFormat(): string
	{
		return $this->model->getDateFormat();
	}
}
