<?php


namespace App\DTO;


class AdminDTO extends AbstractDTO
{
    public $login;
    public $firstname;
    public $surname;
    public $middlename;
    public $password;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }
}