<?php

/*
 * This file is part of the DubtureCustomerIOBundle package.
 *
 * (c) Robert Gruendler <robert@dubture.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dubture\CustomerIOBundle\Tests\Controller;

use Dubture\CustomerIOBundle\Event\WebhookEvent;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class WebhookControllerTest
 * @package Dubture\CustomerIOBundle\Tests\Controller
 */
class WebhookControllerTest extends WebTestCase
{
    public function testIndex()
    {

        $client = self::createClient();
        $raw = <<< BODY
    {
      "event_type": "email_delivered",
      "event_id": "5b68360d2bf711479352",
      "timestamp": 1352005930,
      "data": {
        "customer_id": "568",
        "email_address": "customer@example.com",
        "email_id": "34",
        "subject": "Why haven't you visited lately?",
        "campaign_id": "33",
        "campaign_name": "Inactivity Teaser"
      }
    }
BODY;
        $dispatcher = $client->getKernel()->getContainer()->get('event_dispatcher');
        $triggeredHooks = array();

        $dispatcher->addListener(WebhookEvent::EMAIL_DELIVERED, function(WebHookEvent $event) use (&$triggeredHooks) {
            $triggeredHooks[$event->getType()] = true;
        });

        $client->request(
                'POST',
                '/__dubture/customerio',
                array(),
                array(),
                array('CONTENT_TYPE' => 'application/json'),
                $raw
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($triggeredHooks['customerio.email_delivered']);

    }
}
