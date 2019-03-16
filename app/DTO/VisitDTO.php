<?php

namespace App\DTO;

use Carbon\Carbon;

class VisitDTO extends AbstractDTO
{
    /**
     * @var integer
     */
    public $id = null;

    /**
     * @var integer
     */
    public $lesson_id;

    /**
     * @var integer
     */
    public $student_id;

    /**
     * @var Carbon
     */
    public $created_at;

    /**
     * @var Carbon
     */
    public $updated_at;

    public function __construct($attributes = null)
    {
        parent::__construct($attributes);

        $this->setValidationRules([
            "lesson_id" => "integer",
            "student_id" => "integer"
        ]);
    }
}