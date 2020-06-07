<?php


namespace shop\forms\manage;


use shop\entities\shop\Page;
use yii\base\Model;

class PageForm extends Model
{
    public $title;
    public $content;
    public $slug;
    public $parentId;

    public $meta;
    public $_page;

    public function __construct(Page $page = null, $config = [])
    {
        if ($page) {
            $this->title = $page->title;
            $this->content = $page->content;
            $this->slug = $page->slug;
            $this->meta = $page->meta;
           // $this->parent = $page->slug;

        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['parentId', 'integer'],
            [['title', 'slug', 'content'], 'string'],

        ];
    }

}