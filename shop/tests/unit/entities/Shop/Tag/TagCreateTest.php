<?php


namespace shop\tests\unit\entities\shop\Tag;


use Codeception\Test\Unit;
use shop\entities\shop\Tag;

class TagCreateTest extends Unit
{
    public function testSuccess()
    {
        $tag = Tag::create(
            $name = 'Name',
            $slug = 'slug'
        );
        $this->assertEquals($name, $tag->getName());
        $this->assertEquals($slug, $tag->getSlug());
    }

}