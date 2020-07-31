<?php

namespace Crudly\Encrypted\Tests\Integration;

use Crudly\Encrypted\Tests\TestCase;
use Crudly\Encrypted\Tests\Models\Model;

class CastingOptionsTest extends TestCase
{
	protected $model;
	protected $value;
	protected $encrypted;

	protected function setUp(): void
	{
		parent::setUp();

		$this->model = new Model;
		$this->value = 12.838;
		$this->encrypted = encrypt($this->value);
	}

	/**
	 * Casting for decimal.
	 */
	public function testDecimal(): void
	{
		$this->model->setRawAttributes(['decimal_2' => $this->encrypted]);
		$get = $this->model->decimal_2;
		$this->assertSame('12.84', $get);

		$this->model->setRawAttributes(['decimal_4' => $this->encrypted]);
		$get = $this->model->decimal_4;
		$this->assertSame('12.8380', $get);
	}
}
