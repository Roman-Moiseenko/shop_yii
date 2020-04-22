<?php


namespace shop\forms\manage\shop;


use shop\entities\shop\Tag;
use yii\base\Model;



class TagForm extends Model
{
    public $name;
    public $slug;
   // private int $id;
    private $_tag;

    public function __construct(Tag $tag = null, $config = [])
    {
        if ($tag) {
            $this->name = $tag->name;
            $this->slug = $tag->slug;
            $this->_tag = $tag;
        }
        parent::__construct($config);
    }
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'slug'], 'string', 'max' => 255],
            ['slug', 'match', 'pattern' => '#^[0-9a-z_-]+$#s'],
            [['name', 'slug'], 'unique', 'targetClass' => Tag::class, 'filter' => $this->_tag ? ['<>', 'id', $this->_tag->id] : null],
        ];
    }

}