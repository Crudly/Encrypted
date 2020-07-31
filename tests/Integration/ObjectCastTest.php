<?php

namespace Crudly\Encrypted\Tests\Integration;

use Crudly\Encrypted\Tests\TestCase;
use Crudly\Encrypted\Tests\Models\Model;

use Illuminate\Support\Collection;

class ObjectCastTest extends TestCase
{
	protected $model;
	protected $value;
	protected $encrypted;

    protected function setUp(): void
    {
        parent::setUp();

		$this->model = new Model;
		$this->value = collect(['confidential', 'classified']);
		$this->encrypted = encrypt($this->value);
    }

    /**
     * Encryption for objects.
     *
     * @return void
     */
    public function testSetter(): void
    {
		$this->model->column = $this->value;
		$set = $this->model->getAttributes()['column'];

		$this->assertIsString($set);
		$this->assertNotEquals($this->value, $set);
		$this->assertEquals($this->value, decrypt($set));
    }

    /**
     * Decryption for objects.
     *
     * @return void
     */
    public function testGetter(): void
    {
		$this->model->setRawAttributes(['column' => $this->encrypted]);
		$get = $this->model->column;
		$this->assertInstanceOf(Collection::class, $get);
		$this->assertEquals($this->value, $get);
    }
}
