<?php

/*
 * This file is part of the DubtureCustomerIOBundle package.
 *
 * (c) Robert Gruendler <robert@dubture.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Tracker;

use Dubture\CustomerIOBundle\Event\ActionEvent;
use Dubture\CustomerIOBundle\Event\TrackingEvent;
use Dubture\CustomerIOBundle\Tests\Tracker\TestCustomer;
use Dubture\CustomerIOBundle\Tracking\EventTracker;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/***
 * Class EventTrackerTest
 * @package Tests\Tracker
 */
class EventTrackerTest extends WebTestCase
{
    public function testCustomerCreation()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();

        $api = $this->getMockBuilder('\Customerio\Api')->disableOriginalConstructor()->getMock();

        $response = $this->getMockBuilder('\Customerio\Response')->disableOriginalConstructor()->getMock();

        $response->expects($this->once())->method('success')->willReturn(true);
        $api->expects($this->once())->method('createCustomer')->willReturn($response);

        static::$kernel->getContainer()->get('dubture_customer_io.api', $api);

        /** @var EventTracker $tracker */
        $tracker = static::$kernel->getContainer()->get('dubture_customer_io.tracker');

        $tracker->setApi($api);

        /** @var EventDispatcherInterface $dispatcher */
        $dispatcher = static::$kernel->getContainer()->get('event_dispatcher');

        $customer = new TestCustomer('foo', 'test@example.com', array('foo' => 'bar'));
        $dispatcher->dispatch(TrackingEvent::IDENTIFY, new TrackingEvent($customer));
    }

    /**
     * @expectedException \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     */
    public function testCustomerCreationException()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();

        $api = $this->getMockBuilder('\Customerio\Api')->disableOriginalConstructor()->getMock();

        $response = $this->getMockBuilder('\Customerio\Response')->disableOriginalConstructor()->getMock();

        $response->expects($this->once())->method('success')->willReturn(false);
        $api->expects($this->once())->method('createCustomer')->willReturn($response);

        static::$kernel->getContainer()->get('dubture_customer_io.api', $api);

        /** @var EventTracker $tracker */
        $tracker = static::$kernel->getContainer()->get('dubture_customer_io.tracker');

        $tracker->setApi($api);

        /** @var EventDispatcherInterface $dispatcher */
        $dispatcher = static::$kernel->getContainer()->get('event_dispatcher');

        $customer = new TestCustomer('foo', 'test@example.com', array('foo' => 'bar'));
        $dispatcher->dispatch(TrackingEvent::IDENTIFY, new TrackingEvent($customer));
    }

    public function testEventTracking()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();

        $api = $this->getMockBuilder('\Customerio\Api')->disableOriginalConstructor()->getMock();

        $response = $this->getMockBuilder('\Customerio\Response')->disableOriginalConstructor()->getMock();

        $response->expects($this->once())->method('success')->willReturn(true);
        $api->expects($this->once())->method('fireEvent')->willReturn($response);

        static::$kernel->getContainer()->get('dubture_customer_io.api', $api);

        /** @var EventTracker $tracker */
        $tracker = static::$kernel->getContainer()->get('dubture_customer_io.tracker');

        $tracker->setApi($api);

        /** @var EventDispatcherInterface $dispatcher */
        $dispatcher = static::$kernel->getContainer()->get('event_dispatcher');

        $customer = new TestCustomer('foo', 'test@example.com', array('foo' => 'bar'));
        $dispatcher->dispatch(TrackingEvent::ACTION, new ActionEvent($customer, 'click'));
    }

}