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

use Symfony\Component\EventDispatcher\Event;

/**
 * Class WebhookEvent
 * @package Dubture\CustomerIOBundle\Event
 * @see http://customer.io/docs/webhooks.html
 */
class WebhookEvent extends Event
{

    const EMAIL_DRAFTED                 = "customerio.email_drafted";
    const EMAIL_SENT                    = "customerio.email_sent";
    const EMAIL_DELIVERED               = "customerio.email_delivered";
    const EMAIL_OPENED                  = "customerio.email_opened";
    const EMAIL_CLICKED                 = "customerio.email_clicked";
    const EMAIL_BOUNCED                 = "customerio.email_bounced";
    const EMAIL_SPAMMED                 = "customerio.email_spammed";
    const EMAIL_DROPPED                 = "customerio.email_dropped";
    const EMAIL_FAILED                  = "customerio.email_failed";
    const CUSTOMER_UNSUBSCRIBED         = "customerio.customer_unsubscribed";
    const CUSTOMER_SUBSCRIBED           = "customerio.customer_subscribed";

    /**
     * @var array
     */
    private $data;

    /**
     * @var
     */
    private $type;

    /**
     * @param $type
     * @param array $data
     */
    public function __construct($type, array $data)
    {
        $this->data = $data;
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->data['data']['email_address'];
    }

    /**
     * @return string
     */
    public function getCustomerId()
    {
        return $this->data['data']['customer_id'];
    }
}
