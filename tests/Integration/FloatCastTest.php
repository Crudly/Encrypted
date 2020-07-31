<?php

namespace Crudly\Encrypted\Tests\Integration;

use Crudly\Encrypted\Tests\TestCase;
use Crudly\Encrypted\Tests\Models\Model;

class FloatCastTest extends TestCase
{
	protected $model;
	protected $value;
	protected $encrypted;

	protected function setUp(): void
	{
		parent::setUp();

		$this->model = new Model;
		$this->value = 44.7;
		$this->encrypted = encrypt($this->value);
	}

	/**
	 * Encryption for floats.
	 */
	public function testSetter(): void
	{
		$this->model->column = $this->value;
		$set = $this->model->getAttributes()['column'];

		$this->assertIsString($set);
		$this->assertNotSame($this->value, $set);
		$this->assertSame($this->value, decrypt($set));
	}

	/**
	 * Decryption for floats.
	 */
	public function testGetter(): void
	{
		$this->model->setRawAttributes(['column' => $this->encrypted]);
		$get = $this->model->column;
		$this->assertSame($this->value, $get);
	}

	/**
	 * Casting to float.
	 */
	public function testCaster(): void
	{
		$this->model->setRawAttributes(['float_float' => encrypt(35)]);
		$get = $this->model->float_float;
		$this->assertSame(35.0, $get);

		$this->model->setRawAttributes(['float_float' => encrypt('49.87')]);
		$get = $this->model->float_float;
		$this->assertSame(49.87, $get);
	}

	/**
	 * Casting to float (alias `real`).
	 */
	public function testCasterAliasReal(): void
	{
		$this->model->setRawAttributes(['float_real' => encrypt('22.3')]);
		$get = $this->model->float_real;
		$this->assertSame(22.3, $get);
	}

	/**
	 * Casting to float (alias `double`).
	 */
	public function testCasterAliasDouble(): void
	{
		$this->model->setRawAttributes(['float_double' => encrypt((int) 15)]);
		$get = $this->model->float_double;
		$this->assertSame(15.0, $get);
	}
}
