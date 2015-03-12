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

/**
 * Class ActionEvent
 * @package Event
 */
class ActionEvent extends TrackingEvent
{
    /**
     * @var string
     */
    private $action;

    /**
     * @var array
     */
    private $attributes;

    /**
     * @param CustomerInterface $customer
     * @param null $action
     * @param array $attributes
     */
    public function __construct(CustomerInterface $customer, $action, $attributes = array())
    {
        parent::__construct($customer);

        $this->action = $action;
        $this->attributes = $attributes;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }
}