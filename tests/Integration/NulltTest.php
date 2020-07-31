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
    }

    /**
     * Encryption for null.
     *
     * @return void
     */
    public function testSetter(): void
    {
		$this->model->column = $this->value;
		$set = $this->model->getAttributes()['column'];

		$this->assertNull($set);
    }

    /**
     * Decryption for null.
     *
     * @return void
     */
    public function testGetterFromNull(): void
    {
		$this->model->setRawAttributes(['column' => null]);
		$get = $this->model->column;
		$this->assertSame($this->value, $get);
	}
}
