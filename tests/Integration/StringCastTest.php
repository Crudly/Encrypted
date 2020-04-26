<?php

namespace Crudly\Encrypted\Tests\Integration;

use Crudly\Encrypted\Cast;
use Crudly\Encrypted\Tests\TestCase;
use Crudly\Encrypted\Tests\Models\Model;

class StringCastTest extends TestCase
{
	protected $model;
	protected $value;
	protected $encrypted;

    protected function setUp(): void
    {
        parent::setUp();

		$this->model = new Model;
		$this->value = 'secret';
		$this->encrypted = encrypt($this->value);
    }

    /**
     * Encryption for strings.
     *
     * @return void
     */
    public function testStringSetter()
    {
		$this->model->column = $this->value;
		$set = $this->model->getAttributes()['column'];

		$this->assertIsString($set);
		$this->assertNotSame($this->value, $set);
		$this->assertSame($this->value, decrypt($set));
    }

    /**
     * Decryption for strings.
     *
     * @return void
     */
    public function testStringGetter()
    {
		$this->model->setRawAttributes(['column' => $this->encrypted]);
		$get = $this->model->column;

		$this->assertIsString($get);
		$this->assertSame($this->value, $get);
	}

    /**
     * Casting to string.
     *
     * @return void
     */
    public function testStringCaster()
    {
		$this->model->setRawAttributes(['string' => encrypt(60.1)]);
		$get = $this->model->string;

		$this->assertIsString($get);
		$this->assertSame('60.1', $get);
	}
}