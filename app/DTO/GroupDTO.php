<?php

namespace App\DTO;

use App\Models\Group;
use App\Models\Lesson;
use Illuminate\Database\Eloquent\Model;

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

    protected function handleModelToDtoParsing(Model $model)
    {
        parent::handleModelToDtoParsing($model);

        if ($model instanceof Group) {
            $this->lessons = array_map(function ($elem) {
                return $elem['id'];
            }, $model->lessons()->get(['id'])->toArray());

            $this->students = array_map(function ($elem) {
                return $elem['id'];
            }, $model->students()->get(['id'])->toArray());
        }
    }
}