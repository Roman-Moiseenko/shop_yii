<?php


namespace shop\forms\data;


use shop\entities\Params;
use yii\base\Model;

class ParamsForm extends Model
{
    public $key;
    public $value;
    public $description;
    
    public function __construct(Params $params = null, $config = [])
    {
        if ($params) {
            $this->key = $params->key;
            $this->value = $params->value;
            $this->description = $params->description;
        }
        parent::__construct($config);
    }
    public function rules()
    {
        return [
            [['key', 'value', 'description'], 'string'],
            [['key', 'value'], 'required'],
        ];
    }


}