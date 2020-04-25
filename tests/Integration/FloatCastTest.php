<?php

namespace Crudly\Encrypted\Tests\Integration;

use Crudly\Encrypted\Cast;
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
     *
     * @return void
     */
    public function testFloatSetter()
    {
		$this->model->column = $this->value;
		$set = $this->model->getAttributes()['column'];

		$this->assertIsString($set);
		$this->assertNotSame($this->value, $set);
		$this->assertSame($this->value, decrypt($set));
    }

    /**
     * Decryption for floats.
     *
     * @return void
     */
    public function testFloatGetter()
    {
		$this->model->setRawAttributes(['column' => $this->encrypted]);
		$get = $this->model->column;

		$this->assertIsFloat($get);
		$this->assertSame($this->value, $get);
    }
}