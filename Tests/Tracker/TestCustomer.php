<?php

/*
 * This file is part of the DubtureCustomerIOBundle package.
 *
 * (c) Robert Gruendler <robert@dubture.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dubture\CustomerIOBundle\Tests\Tracker;

use Dubture\CustomerIOBundle\Model\CustomerInterface;

/**
 * Class TestCustomer
 * @package Tests\Tracker
 */
class TestCustomer implements CustomerInterface
{
    /**
     * @var
     */
    private $id;

    /**
     * @var
     */
    private $email;

    /**
     * @var array
     */
    private $attributes;

    /**
     * @param $id
     * @param $email
     * @param array $attributes
     */
    public function __construct($id, $email, $attributes = array())
    {
        $this->id = $id;
        $this->email = $email;
        $this->attributes = $attributes;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }
}