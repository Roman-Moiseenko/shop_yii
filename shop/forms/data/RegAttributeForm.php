<?php


namespace shop\forms\data;


use shop\entities\shop\Category;
use shop\entities\shop\Characteristic;
use shop\entities\shop\RegAttribute;
use yii\base\Model;
use yii\helpers\ArrayHelper;


/**
 * Class RegAttributeForm
 * @package shop\forms\data
 * @property integer $category_id
 * @property string $reg_math
 * @property integer $characteristic_id
 */
class RegAttributeForm extends Model
{

    /**
     * @var RegAttribute
     */
    private $reg;
    public $category_id;
    public $reg_match;
    public $characteristic_id;

    public function __construct(RegAttribute $reg = null, $config = [])
    {
        if ($reg) {
            $this->category_id = $reg->category_id;
            $this->reg_match = $reg->reg_match;
            $this->characteristic_id = $reg->characteristic_id;
        }
        parent::__construct($config);
        $this->reg = $reg;
    }

    public function rules()
    {
        return [
            [['category_id', 'characteristic_id'], 'integer'],
            [['category_id', 'characteristic_id', 'reg_match'], 'required'],
            [['reg_match'], 'string'],
        ];
    }

    public function characteristicList(): array
    {
        return ArrayHelper::map(Characteristic::find()->orderBy('name')->asArray()->all(),
            'id',
            function (array $characteristic) {
            return $characteristic['name'];
            });
    }

    public function categoriesList(): array
    {
        return ArrayHelper::map(
            Category::find()->andWhere(['>', 'depth', 0])->orderBy('lft')->asArray()->all(),
            'id',
            function (array $category) {
                return ($category['depth'] > 1 ? str_repeat('-- ', $category['depth'] - 1) . ' ' : '') . $category['name'];
            }
        );
    }
}