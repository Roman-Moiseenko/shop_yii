<?php


namespace shop\entities\behaviors;


use shop\entities\Meta;
use shop\entities\shop\Brand;
use yii\base\Behavior;
use yii\base\Event;
use yii\db\ActiveRecord;
use yii\helpers\Json;

class MetaBehavior extends Behavior
{
    public $attribute = 'meta';
    public $jsonAttribute = 'meta_json';

    public function events(): array
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND, [$this, 'onAfterFind'],
            ActiveRecord::EVENT_BEFORE_UPDATE, [$this, 'onBeforeSave'],
            ActiveRecord::EVENT_BEFORE_INSERT, [$this, 'onBeforeSave']
        ];
    }

    public function onAfterFind(Event $event): void
    {
        /** @var ActiveRecord $brand */
        $brand = $event->sender;
        $meta = Json::decode($brand->getAttribute($this->jsonAttribute));
        $brand->{$this->jsonAttribute} = new Meta(
            $meta['title'] ?? null,
            $meta['description'] ?? null,
            $meta['keywords'] ?? null
        );
    }

    public function onBeforeSave(Event $event): void
    {
        /** @var ActiveRecord $brand */
        $brand = $event->sender;
        $brand->setAttribute($this->jsonAttribute, Json::encode([
            'title' => $brand->{$this->jsonAttribute}->title,
            'description' => $brand->{$this->jsonAttribute}->description,
            'keywords' => $brand->{$this->jsonAttribute}->keywords
        ]));
    }
}