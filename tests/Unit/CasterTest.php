<?php

namespace Crudly\Encrypted\Tests\Unit;

use Crudly\Encrypted\Caster;
use Crudly\Encrypted\Tests\TestCase;

use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * Primitive casts are tested minimally as that is covered in integration.
 *
 * @return void
 */
class CasterTest extends TestCase
{
    /**
     * Cast to string.
     *
     * @return void
     */
    public function testToString()
    {
		$caster = new Caster('string');

		$this->assertIsString($caster->coerce(12));
		$this->assertSame('55.1', $caster->coerce(55.1));
    }

    /**
     * Cast to decimal.
     *
     * @return void
     */
    public function testToDecimal()
    {
		$caster = new Caster('decimal:2');

		$this->assertIsString($caster->coerce(12));
		$this->assertSame('98.00', $caster->coerce(98));
		$this->assertSame('24.00', $caster->coerce('24'));
		$this->assertSame('78.99', $caster->coerce(78.9898));
	}

    /**
     * Cast to datetime.
     *
     * @return void
     */
    public function testToDatetime()
    {
		$caster = new Caster('datetime');
		$casted = $caster->coerce('1592-03-14');

		$this->assertIsObject($casted);
		$this->assertInstanceOf(Carbon::class, $casted);
		$this->assertEquals('1592-03-14', $casted->format('Y-m-d'));
		$this->assertEquals('1592-03-14', $casted->format('Y-m-d'));

		$now = now();
		$noncasted = $caster->coerce($now);
		$this->assertSame($now, $noncasted);
	}

    /**
     * Cast to object.
     *
     * @return void
     */
    public function testToObject()
    {
		$caster = new Caster('object');
		$list = (object) ['secret' => 'classified'];

		$castedJSON = $caster->coerce(json_encode($list));
		$this->assertIsObject($castedJSON);
		$this->assertInstanceOf('stdClass', $castedJSON);
		$this->assertEquals($list, $castedJSON);
		
		$castedObject = $caster->coerce($list);
		$this->assertSame($list, $castedObject);
	}

    /**
     * Cast to array.
     *
     * @return void
     */
    public function testToArray()
    {
		$caster = new Caster('array');
		$list = ['secret', 'classified'];

		$castedJSON = $caster->coerce(json_encode($list));
		$this->assertIsArray($castedJSON);
		$this->assertEquals($list, $castedJSON);
		
		$castedArray = $caster->coerce($list);
		$this->assertSame($list, $castedArray);
	}

    /**
     * Cast to collection.
     *
     * @return void
     */
    public function testToCollection()
    {
		$caster = new Caster('collection');
		$list = ['secret', 'classified'];
		$collection = collect(['secret', 'classified']);

		$castedJSON = $caster->coerce(json_encode($list));
		$this->assertInstanceOf(Collection::class, $castedJSON);
		$this->assertEquals($collection, $castedJSON);
		
		$castedArray = $caster->coerce($list);
		$this->assertInstanceOf(Collection::class, $castedJSON);
		$this->assertSame($list, $castedArray->toArray());
		
		$castedCollection = $caster->coerce($collection);
		$this->assertSame($collection, $castedCollection);
	}
}