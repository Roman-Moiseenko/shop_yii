<?php


namespace shop\services\blog;


use shop\entities\blog\post\Comment;
use shop\forms\blog\CommentForm;
use shop\repositories\blog\PostRepository;
use shop\repositories\UserRepository;

class CommentService
{
    /**
     * @var PostRepository
     */
    private $posts;
    /**
     * @var UserRepository
     */
    private $users;

    public function __construct(PostRepository $posts, UserRepository $users)
    {
        $this->posts = $posts;
        $this->users = $users;
    }

    public function create($postId, $userId, CommentForm $form): Comment
    {
        $post = $this->posts->get($postId);
        $user = $this->users->get($userId);
        $comment = $post->addComment($user->id, $form->parentId, $form->text);
        $this->posts->save($post);
        return $comment;
    }
}