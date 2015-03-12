<?php

/*
 * This file is part of the DubtureCustomerIOBundle package.
 *
 * (c) Robert Gruendler <robert@dubture.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dubture\CustomerIOBundle\Model;

/**
 * Interface CustomerInterface
 * @package Dubture\CustomerIOBundle\Model
 */
interface CustomerInterface
{

    /**
     * @return string
     */
    function getId();

    /**
     * @return string
     */
    function getEmail();

    /**
     * @return array
     */
    function getAttributes();

}