<?php


namespace shop\services\manage;


use shop\entities\Meta;
use shop\entities\shop\Page;
use shop\forms\manage\PageForm;
use shop\repositories\PageRepository;

class PageManageService
{

    /**
     * @var PageRepository
     */
    private $pages;

    public function __construct(PageRepository $pages)
    {
        $this->pages = $pages;
    }

    public function create(PageForm $form): Page
    {
        $parent = $this->pages->get($form->parentId);
        $page = Page::create(
            $form->title,
            $form->slug,
            $form->content,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );
        $page->appendTo($parent);
        $this->pages->save($page);
        return $page;
    }

    public function edit($id, PageForm $form): void
    {
        $parent = $this->pages->get($form->parentId);
        $page = $this->pages->get($id);
        $page->edit(
            $form->title,
            $form->slug,
            $form->content,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );
        $page->appendTo($parent);
        $this->pages->save($page);
    }
}