<?php

namespace Crudly\Encrypted\Tests\Integration;

use Crudly\Encrypted\Tests\TestCase;
use Crudly\Encrypted\Tests\Models\Model;

use Carbon\Carbon;

class DatetimeCastTest extends TestCase
{
	protected $model;
	protected $value;
	protected $encrypted;

    protected function setUp(): void
    {
        parent::setUp();

		$this->model = new Model;
		$this->value = now();
		$this->encrypted = encrypt($this->value);
    }

    /**
     * Encryption for datetime.
     *
     * @return void
     */
    public function testSetter()
    {
		$this->model->datetime = $this->value;
		$set = $this->model->getAttributes()['datetime'];

		$this->assertIsString($set);
		$this->assertNotEquals($this->value, $set);
		$this->assertEquals($this->value, decrypt($set));
		$this->assertTrue($this->value->equalTo(decrypt($set)));
    }

    /**
     * Decryption for datetime.
     *
     * @return void
     */
    public function testGetter()
    {
		$this->model->setRawAttributes(['datetime' => $this->encrypted]);
		$get = $this->model->datetime;
		$this->assertInstanceOf(Carbon::class, $get);
		$this->assertEquals($this->value, $get);
		$this->assertTrue($this->value->equalTo($get));
    }

    /**
     * Casting to datetime.
     *
     * @return void
     */
    public function testCaster()
    {
		$this->model->setRawAttributes(['datetime' => encrypt($this->value->format('Y-m-d H:i:s.u'))]);
		$get = $this->model->datetime;
		$this->assertInstanceOf(Carbon::class, $get);
		$this->assertEquals($this->value, $get);
		$this->assertTrue($this->value->equalTo($get));
	}
}
