<?php

namespace App\DTO;

class StudentDTO extends AbstractDTO
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
    public $deviceUid;

    /**
     * @var integer
     */
    public $groupId;

    /**
     * @var string
     */
    public $plainPassword;

    protected $remapping = [
        'plainPassword' => 'password',
        'deviceUid' => 'device_uid',
        'groupId' => 'group_id'
    ];

    public function __construct($attributes = null)
    {
        parent::__construct($attributes);

        $this->setValidationRules([
            "login" => "required|string|min:3",
            "firstname" => "required|string|min:2",
            "surname" => "required|string|min:2",
            "middlename" => "required|string|min:2",
            "deviceUid" => "required|string|min:3",
            "groupId" => "required|integer|min:1|exists:groups,id",
            "plainPassword" => "required|string|min:3"
        ]);
    }
}