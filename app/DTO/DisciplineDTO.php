<?php

namespace App\DTO;

use App\Models\Discipline;
use Illuminate\Database\Eloquent\Model;

class DisciplineDTO extends AbstractDTO
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

        if ($model instanceof Discipline) {
            $this->professors = array_map(function ($elem) {
                return $elem['id'];
            }, $model->professors()->get(['id'])->toArray());
        }
    }
}