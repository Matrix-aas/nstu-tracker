<?php

namespace App\DTO;

class LessonDTO extends AbstractDTO
{
    /**
     * @var integer
     */
    public $id = null;

    /**
     * @var integer
     */
    public $discipline_id;

    /**
     * @var integer
     */
    public $professor_id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $datetime;

    public function __construct($attributes = null)
    {
        parent::__construct($attributes);
        $this->setValidationRules([
            "name" => "required|string|min:3"
        ]);
    }
}