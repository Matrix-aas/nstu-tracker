<?php

namespace App\DTO;

class AdminDTO extends AbstractDTO
{
    /**
     * @var integer
     */
    public $id = null;

    /**
     * @var string
     */
    public $login;

    /**
     * @var string
     */
    public $firstname;

    /**
     * @var string
     */
    public $surname;

    /**
     * @var string
     */
    public $middlename;

    /**
     * @var string
     */
    public $plainPassword;

    protected $remapping = [
        'plainPassword' => 'password'
    ];
}