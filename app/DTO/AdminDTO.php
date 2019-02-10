<?php


namespace App\DTO;


class AdminDTO extends AbstractDTO
{
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