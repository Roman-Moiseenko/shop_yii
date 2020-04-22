<?php


namespace shop\tests\unit\entities\Shop\Tag;


use Codeception\Test\Unit;
use shop\entities\Shop\Tag;

class TagEditTest extends Unit
{
    public function testSuccess()
    {
        $tag = Tag::create(
            $name = 'Name',
            $slug = 'slug'
        );
        $tag->edit($name = 'New Name', $slug = 'New slug');
        $this->assertEquals($name, $tag->getName());
        $this->assertEquals($slug, $tag->getSlug());
    }

}