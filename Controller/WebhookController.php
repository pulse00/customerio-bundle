<?php

/*
 * This file is part of the DubtureCustomerIOBundle package.
 *
 * (c) Robert Gruendler <robert@dubture.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dubture\CustomerIOBundle\Controller;

use Dubture\CustomerIOBundle\Event\WebhookEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class WebhookController
 * @package Dubture\CustomerIOBundle\Controller
 */
class WebhookController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     * @throws BadRequestHttpException
     */
    public function postAction(Request $request)
    {
        /** @var LoggerInterface $logger */
        $logger = $this->get('logger');

        $body = $request->getContent();
        $logger->info('Received customer.io webhook ' . $body);

        $eventData = json_decode($body, true);

        if ($eventData === false || $eventData === null) {
            $logger->error('Unable to decode customer.io webhook. Body: ' . $body);
            throw new BadRequestHttpException('Unable to parse request body');
        }

        /** @var EventDispatcherInterface $dispatcher */
        $dispatcher = $this->get('event_dispatcher');

        $type = 'customerio.' . $eventData['event_type'];
        $logger->info('Dispatching ' . $type . ' event');
        $dispatcher->dispatch($type, new WebHookEvent($type, $eventData));

        return new Response();
    }
}
