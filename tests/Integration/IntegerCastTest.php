<?php

namespace Crudly\Encrypted\Tests\Integration;

use Crudly\Encrypted\Tests\TestCase;
use Crudly\Encrypted\Tests\Models\Model;

class IntegerCastTest extends TestCase
{
	protected $model;
	protected $value;
	protected $encrypted;

    protected function setUp(): void
    {
        parent::setUp();

		$this->model = new Model;
		$this->value = 359;
		$this->encrypted = encrypt($this->value);
    }

    /**
     * Encryption for integers.
     *
     * @return void
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
     * Decryption for integers.
     *
     * @return void
     */
    public function testGetter(): void
    {
		$this->model->setRawAttributes(['column' => $this->encrypted]);
		$get = $this->model->column;
		$this->assertSame($this->value, $get);
    }

    /**
     * Casting to integer.
     *
     * @return void
     */
    public function testCaster(): void
    {
		$this->model->setRawAttributes(['integer_integer' => encrypt(60.1)]);
		$get = $this->model->integer_integer;
		$this->assertSame(60, $get);

		$this->model->setRawAttributes(['integer_integer' => encrypt('55')]);
		$get = $this->model->integer_integer;
		$this->assertSame(55, $get);
	}

    /**
     * Casting to integer (alias `int`).
     *
     * @return void
     */
    public function testCasterAliasInt(): void
    {
		$this->model->setRawAttributes(['integer_int' => encrypt(73.4)]);
		$get = $this->model->integer_int;
		$this->assertSame(73, $get);
	}
}
