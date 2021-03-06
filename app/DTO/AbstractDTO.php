<?php

namespace App\DTO;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

abstract class AbstractDTO extends \StdClass implements Arrayable
{
    private $validationRules = null;
    private $validationMessages = null;

    /**
     * Warning! Remapping only in DTO -> Model side!
     *
     * @var array
     */
    protected $remapping = [];

    /**
     * AbstractDTO constructor.
     * @param array|Model $attributes
     */
    public function __construct($attributes = null)
    {
        if ($attributes) {
            if (is_array($attributes)) {
                foreach ($attributes as $key => $value) {
                    if (property_exists($this, $key))
                        $this->{$key} = $value;
                    else
                        throw new \InvalidArgumentException(static::class . " doesn't have attribute \"" . $key . "\"!");
                }
            } else if ($attributes instanceof Model) {
                foreach ($attributes->getAttributes() as $key => $value) {
                    if (property_exists($this, $key))
                        $this->{$key} = $value;
                }
                $this->handleModelToDtoParsing($attributes);
            } else
                throw new \InvalidArgumentException('$attributes must be array or Model instance!');
        }
    }

    /**
     * Set transform to model validation rules
     * @param $rules
     * @param null $messages
     * @return $this
     */
    public function setValidationRules(array $rules, array $messages = null)
    {
        $this->validationRules = $rules;
        $this->validationMessages = $messages;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getValidationRules()
    {
        return $this->validationRules;
    }

    /**
     * @return array|null
     */
    public function getValidationMessages()
    {
        return $this->validationMessages;
    }

    /**
     * Convert all this class fields to array
     * @return array
     */
    public function toArray()
    {
        $array = get_object_vars($this);
        unset($array["validationRules"]);
        unset($array["validationMessages"]);
        unset($array["remapping"]);
        return $array;
    }

    /**
     * Remove empty fields from DTO
     * Use for updating models
     */
    public function removeEmptyFields()
    {
        $attributes = $this->toArray();
        foreach ($attributes as $key => $value) {
            if (empty($value))
                unset($this->{$key});
        }
    }

    /**
     * Convert all this class fields to array and remap it by remapping rules
     * @return array
     */
    public function toRemappedArray()
    {
        return array_remap($this->toArray(), $this->remapping);
    }

    /**
     * Fill model attributes from DTO
     * @param Model $model
     * @param bool $validate
     * @throws ValidationException
     */
    public function toModel(Model $model, bool $validate = false)
    {
        $attributes = $this->toRemappedArray();

        if ($validate && ($this->validationRules || property_exists($model, "validationRules"))) {
            if ($this->validationRules) {
                $validator = Validator::make($this->toArray(), $this->validationRules, $this->validationMessages ?? []);
            } else {
                $validator = Validator::make($attributes, $model->validationRules, $this->validationMessages ?? []);
            }
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }
        }

        $fillableFields = array_merge($model->getFillable(), $model->getHidden());
        foreach ($attributes as $key => $value) {
            if (in_array($key, $fillableFields)) {
                $model->setAttribute($key, $value);
            }
        }
    }

    /**
     * Create or load Model and fill it attributes from DTO
     * @param string $modelClass
     * @param bool $validate
     * @return Model
     * @throws ValidationException
     */
    public function buildModel(string $modelClass, bool $validate = false): Model
    {
        if (property_exists($this, "id") && !empty($this->getId())) {
            $model = $modelClass::query()->find($this->getId());
            if (!$model)
                $model = new $modelClass();
            /** @var Model $model */
            $model->setAttribute($model->getKeyName(), $this->getId());
        } else
            $model = new $modelClass();
        $this->toModel($model, $validate);
        return $model;
    }

    public function __call($name, $arguments)
    {
        $argumentsCount = count($arguments);
        if ($argumentsCount > 1 || strlen($name) < 4)
            throw new \BadMethodCallException();

        $firstThreeLetters = substr($name, 0, 3);
        if ($firstThreeLetters == "set") {
            if ($argumentsCount != 1)
                throw new \BadMethodCallException();
            $key = substr($name, 3);
            $snakeKey = snake_case($key);
            $camelKey = camel_case($key);
            if (property_exists($this, $snakeKey))
                $this->{$snakeKey} = $arguments[0];
            else if (property_exists($this, $camelKey))
                $this->{$camelKey} = $arguments[0];
            else
                throw new \BadMethodCallException();
            return $this;
        } else if ($firstThreeLetters == "get") {
            $key = substr($name, 3);
            $snakeKey = snake_case($key);
            $camelKey = camel_case($key);
            if (property_exists($this, $snakeKey))
                return $this->{$snakeKey};
            else if (property_exists($this, $camelKey))
                return $this->{$camelKey};
            else if ($argumentsCount == 1)
                return $arguments[0];
            else
                throw new \BadMethodCallException();
        } else
            throw new \BadMethodCallException();
    }

    protected function handleModelToDtoParsing(Model $model)
    {
    }
}