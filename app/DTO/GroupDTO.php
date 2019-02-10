<?php


namespace App\DTO;


class GroupDTO extends AbstractDTO
{
    /**
     * @var integer
     */
    public $id = null;

    /**
     * @var string
     */
    public $name;

    public function __construct($attributes = null)
    {
        parent::__construct($attributes);
        $this->setValidationRules([
            "name" => "required|string|min:3"
        ]);
    }
}