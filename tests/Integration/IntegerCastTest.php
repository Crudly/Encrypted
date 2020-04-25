<?php

namespace Crudly\Encrypted\Tests\Integration;

use Crudly\Encrypted\Cast;
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
    public function testIntegerSetter()
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
    public function testIntegerGetter()
    {
		$this->model->setRawAttributes(['column' => $this->encrypted]);
		$get = $this->model->column;

		$this->assertIsInt($get);
		$this->assertSame($this->value, $get);
    }
}