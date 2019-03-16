<?php

namespace App\DTO;

use App\Models\Lesson;
use Illuminate\Database\Eloquent\Model;

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

    protected function handleModelToDtoParsing(Model $model)
    {
        parent::handleModelToDtoParsing($model);

        if ($model instanceof Lesson) {
            $this->groups = array_map(function ($elem) {
                return $elem['id'];
            }, $model->groups()->get(['id'])->toArray());

            $this->visits = array_map(function ($elem) {
                return $elem['id'];
            }, $model->visits()->get(['id'])->toArray());
        }
    }
}