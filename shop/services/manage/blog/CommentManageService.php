<?php


namespace shop\services\manage\blog;

use shop\forms\manage\blog\post\CommentEditForm;
use shop\repositories\blog\PostRepository;

class CommentManageService
{
    /**
     * @var PostRepository
     */
    private $post;

    public function __construct(PostRepository $post)
    {
        $this->post = $post;
    }

    public function edit($postId, $id, CommentEditForm $form): void
    {
        $post = $this->post->get($postId);
        $post->editComment($id, $form->parentId, $form->text);
        $this->post->save($post);
    }

    public function activate($postId, $id): void
    {
        $post = $this->post->get($postId);
        $post->activateComment($id);
        $this->post->save($post);
    }

    public function remove($postId, $id): void
    {
        $post = $this->post->get($postId);
        $post->removeComment($id);
        $this->post->save($post);
    }
}