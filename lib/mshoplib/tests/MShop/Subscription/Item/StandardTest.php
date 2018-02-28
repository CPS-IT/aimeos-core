<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2018
 */


namespace Aimeos\MShop\Subscription\Item;


class StandardTest extends \PHPUnit\Framework\TestCase
{
	private $object;
	private $values;


	protected function setUp()
	{
		$this->values = array(
			'subscription.id' => 15,
			'subscription.siteid' => 99,
			'subscription.ordprodid' => 123,
			'subscription.datenext' => '2000-01-01 00:00:00',
			'subscription.dateend' => '2100-01-01 00:00:00',
			'subscription.interval' => 'P1Y',
			'subscription.status' => 1,
			'subscription.mtime' => '2018-01-01 00:00:02',
			'subscription.ctime' => '2018-01-01 00:00:01',
			'subscription.editor' => 'unitTestUser'
		);

		$this->object = new \Aimeos\MShop\Subscription\Item\Standard( $this->values );
	}

	protected function tearDown()
	{
		unset( $this->object );
	}

	public function testGetId()
	{
		$this->assertEquals( $this->values['subscription.id'], $this->object->getId() );
	}

	public function testSetId()
	{
		$return = $this->object->setId( null );

		$this->assertInstanceOf( '\Aimeos\MShop\Subscription\Item\Iface', $return );
		$this->assertEquals( null, $this->object->getId() );
		$this->assertTrue( $this->object->isModified() );

		$return = $this->object->setId( 15 );

		$this->assertInstanceOf( '\Aimeos\MShop\Subscription\Item\Iface', $return );
		$this->assertEquals( 15, $this->object->getId() );
		$this->assertFalse( $this->object->isModified() );

		$this->setExpectedException( '\\Aimeos\\MShop\\Exception' );
		$this->object->setId( 6 );
	}

	public function testGetSiteId()
	{
		$this->assertEquals( 99, $this->object->getSiteId() );
	}

	public function testGetOrderProductId()
	{
		$this->assertEquals( $this->values['subscription.ordprodid'], $this->object->getOrderProductId() );
	}

	public function testSetOrderProductId()
	{
		$return = $this->object->setOrderProductId( 15 );

		$this->assertInstanceOf( '\Aimeos\MShop\Subscription\Item\Iface', $return );
		$this->assertEquals( 15, $this->object->getOrderProductId() );
		$this->assertTrue( $this->object->isModified() );
	}

	public function testGetDateNext()
	{
		$this->assertEquals( $this->values['subscription.datenext'], $this->object->getDateNext() );
	}

	public function testSetDateNext()
	{
		$return = $this->object->setDateNext( '2018-01-01 00:00:00' );

		$this->assertInstanceOf( '\Aimeos\MShop\Subscription\Item\Iface', $return );
		$this->assertEquals( '2018-01-01 00:00:00', $this->object->getDateNext() );
		$this->assertTrue( $this->object->isModified() );
	}

	public function testGetDateEnd()
	{
		$this->assertEquals( $this->values['subscription.dateend'], $this->object->getDateEnd() );
	}

	public function testSetDateEnd()
	{
		$return = $this->object->setDateEnd( '2020-01-01 00:00:00' );

		$this->assertInstanceOf( '\Aimeos\MShop\Subscription\Item\Iface', $return );
		$this->assertEquals( '2020-01-01 00:00:00', $this->object->getDateEnd() );
		$this->assertTrue( $this->object->isModified() );

		$this->setExpectedException( '\\Aimeos\\MShop\\Exception' );
		$this->object->setDateEnd( '2008-34-12' );
	}

	public function testGetInterval()
	{
		$this->assertEquals( $this->values['subscription.interval'], $this->object->getInterval() );
	}

	public function testSetInterval()
	{
		$return = $this->object->setInterval( 'P1M' );

		$this->assertInstanceOf( '\Aimeos\MShop\Subscription\Item\Iface', $return );
		$this->assertEquals( 'P1M', $this->object->getInterval() );
		$this->assertTrue( $this->object->isModified() );
	}

	public function testGetStatus()
	{
		$this->assertEquals( $this->values['subscription.status'], $this->object->getStatus() );
	}

	public function testSetStatus()
	{
		$return = $this->object->setStatus( 0 );

		$this->assertInstanceOf( '\Aimeos\MShop\Subscription\Item\Iface', $return );
		$this->assertEquals( 0, $this->object->getStatus() );
		$this->assertTrue( $this->object->isModified() );
	}

	public function testGetTimeModified()
	{
		$this->assertEquals( '2018-01-01 00:00:02', $this->object->getTimeModified() );
	}

	public function testGetTimeCreated()
	{
		$this->assertEquals( '2018-01-01 00:00:01', $this->object->getTimeCreated() );
	}

	public function testGetEditor()
	{
		$this->assertEquals( 'unitTestUser', $this->object->getEditor() );
	}


	public function testGetResourceType()
	{
		$this->assertEquals( 'subscription', $this->object->getResourceType() );
	}


	public function testFromArray()
	{
		$item = new \Aimeos\MShop\Subscription\Item\Standard();

		$list = array(
			'subscription.id' => 1,
			'subscription.ordprodid' => 2,
			'subscription.datenext' => '2019-01-01 00:00:00',
			'subscription.dateend' => '2020-01-01 00:00:00',
			'subscription.interval' => 'P1Y',
			'subscription.status' => 1,
		);

		$unknown = $item->fromArray( $list );

		$this->assertEquals( [], $unknown );

		$this->assertEquals( $list['subscription.id'], $item->getId() );
		$this->assertEquals( $list['subscription.ordprodid'], $item->getOrderProductId() );
		$this->assertEquals( $list['subscription.datenext'], $item->getDateNext() );
		$this->assertEquals( $list['subscription.dateend'], $item->getDateEnd() );
		$this->assertEquals( $list['subscription.interval'], $item->getInterval() );
		$this->assertEquals( $list['subscription.status'], $item->getStatus() );
	}


	public function testToArray()
	{
		$list = $this->object->toArray( true );
		$this->assertEquals( count( $this->values ), count( $list ) );

		$this->assertEquals( $this->object->getId(), $list['subscription.id'] );
		$this->assertEquals( $this->object->getSiteId(), $list['subscription.siteid'] );
		$this->assertEquals( $this->object->getOrderProductId(), $list['subscription.ordprodid'] );
		$this->assertEquals( $this->object->getDateNext(), $list['subscription.datenext'] );
		$this->assertEquals( $this->object->getDateEnd(), $list['subscription.dateend'] );
		$this->assertEquals( $this->object->getInterval(), $list['subscription.interval'] );
		$this->assertEquals( $this->object->getStatus(), $list['subscription.status'] );
		$this->assertEquals( $this->object->getTimeModified(), $list['subscription.mtime'] );
		$this->assertEquals( $this->object->getTimeCreated(), $list['subscription.ctime'] );
		$this->assertEquals( $this->object->getEditor(), $list['subscription.editor'] );
	}

	public function testIsModified()
	{
		$this->assertFalse( $this->object->isModified() );
	}
}