<?php

namespace Crudly\Encrypted\Tests\Integration;

use Crudly\Encrypted\Cast;
use Crudly\Encrypted\Tests\TestCase;
use Crudly\Encrypted\Tests\Models\Model;

class BoolCastTest extends TestCase
{
	protected $model;
	protected $value;
	protected $encrypted;

    protected function setUp(): void
    {
        parent::setUp();

		$this->model = new Model;
		$this->value = true;
		$this->encrypted = encrypt($this->value);
    }

    /**
     * Encryption for booleans.
     *
     * @return void
     */
    public function testSetter()
    {
		$this->model->column = $this->value;
		$set = $this->model->getAttributes()['column'];

		$this->assertIsString($set);
		$this->assertNotSame($this->value, $set);
		$this->assertSame($this->value, decrypt($set));
    }

    /**
     * Decryption for booleans.
     *
     * @return void
     */
    public function testGetter()
    {
		$this->model->setRawAttributes(['column' => $this->encrypted]);
		$get = $this->model->column;

		$this->assertIsBool($get);
		$this->assertSame($this->value, $get);
    }

    /**
     * Casting to bool.
     *
     * @return void
     */
    public function testCaster()
    {
		$this->model->setRawAttributes(['bool_bool' => encrypt('true')]);
		$get = $this->model->bool_bool;
		$this->assertSame(true, $get);

		$this->model->setRawAttributes(['bool_bool' => encrypt('false')]);
		$get = $this->model->bool_bool;
		$this->assertSame(true, $get);

		$this->model->setRawAttributes(['bool_bool' => encrypt(1)]);
		$get = $this->model->bool_bool;
		$this->assertSame(true, $get);

		$this->model->setRawAttributes(['bool_bool' => encrypt(15)]);
		$get = $this->model->bool_bool;
		$this->assertSame(true, $get);

		$this->model->setRawAttributes(['bool_bool' => encrypt(0)]);
		$get = $this->model->bool_bool;
		$this->assertSame(false, $get);

		$this->model->setRawAttributes(['bool_bool' => encrypt('')]);
		$get = $this->model->bool_bool;
		$this->assertSame(false, $get);
	}

    /**
     * Casting to bool (alias `boolean`).
     *
     * @return void
     */
    public function testCasterAliasBooelan()
    {
		$this->model->setRawAttributes(['bool_boolean' => encrypt('true')]);
		$get = $this->model->bool_boolean;
		$this->assertSame(true, $get);
	}
}