<?php

namespace App\DTO;

class ApiTokenDTO extends AbstractDTO
{
    /**
     * @var string
     */
    public $token;

    /**
     * @var string
     */
    public $ip;

    /**
     * @var integer
     */
    public $user_id;

    /**
     * @var integer
     */
    public $user_role;

    /**
     * @var boolean
     */
    public $remember;
}