<?php

namespace Crudly\Encrypted\Tests\Integration;

use Crudly\Encrypted\Tests\TestCase;
use Crudly\Encrypted\Tests\Models\Model;

class NullTest extends TestCase
{
	protected $model;
	protected $value;
	protected $encrypted;

	protected function setUp(): void
	{
		parent::setUp();

		$this->model = new Model;
		$this->value = null;
		$this->encrypted = encrypt($this->value);
	}

	/**
	 * Encryption for null.
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
	 * Decryption for null.
	 */
	public function testGetterFromNull(): void
	{
		$this->model->setRawAttributes(['column' => null]);
		$get = $this->model->column;
		$this->assertSame($this->value, $get);
	}
}
