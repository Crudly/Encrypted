<?php

namespace Crudly\Encrypted\Tests\Integration;

use Crudly\Encrypted\Tests\TestCase;
use Crudly\Encrypted\Tests\Models\Model;

use Hash;

class PasswordTest extends TestCase
{
	protected $model;
	protected $value;
	protected $encrypted;

    protected function setUp(): void
    {
        parent::setUp();

		$this->model = new Model;
		$this->value = 'secret';
    }

    /**
     * Encryption for strings.
     *
     * @return void
     */
    public function testSetter(): void
    {
		$this->model->password = $this->value;
		$set = $this->model->getAttributes()['password'];
		$get = $this->model->password;

		$this->assertIsString($set);
		$this->assertNotSame($this->value, $set);
		$this->assertNotSame($this->value, $get);
		$this->assertSame($set, $get);
		$this->assertTrue(Hash::check($this->value, $get));
    }
}
