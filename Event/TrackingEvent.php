<?php

/*
 * This file is part of the DubtureCustomerIOBundle package.
 *
 * (c) Robert Gruendler <robert@dubture.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dubture\CustomerIOBundle\Event;

use Dubture\CustomerIOBundle\Model\CustomerInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class CustomerIOEvent
 * @package Event
 */
class TrackingEvent extends Event
{
    const IDENTIFY = "customerio.identify";

    const ACTION = "customerio.action";

    /**
     * @var CustomerInterface
     */
    private $customer;

    /**
     * @param CustomerInterface $customer
     */
    public function __construct(CustomerInterface $customer)
    {
        $this->customer = $customer;
    }

    /**
     * @return CustomerInterface
     */
    public function getCustomer()
    {
        return $this->customer;
    }
}