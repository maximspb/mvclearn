<?php
namespace App\Controllers;

use App\Exceptions\CommentException;
use App\Exceptions\DeleteCommentException;
use App\Models\Comment;

class CommentController extends Controller
{
    public function actionCreate()
    {
        $text = $this->request->addRequest('text');
        $username = $this->request->addRequest('username');
        $articleId = $this->request->addRequest('articleId');

        if (!empty($text) && !empty($username) && !empty($articleId)) {
            try {
                $comment = new Comment($articleId, $username, $text);
                $comment->save();
                header('Location:/news/read/?id='.$articleId);
            } catch (\Throwable $e) {
                throw new CommentException();
            }
        }
    }


    public function actionDelete()
    {
        $commentId = $this->request->addRequest('commentId');
        $articleId = $this->request->addRequest('articleId');
        try {
            Comment::delete($commentId);
            header('Location:/news/read/?id='.$articleId);
        } catch (\Throwable $exception) {
            throw new DeleteCommentException();
        }
    }
}
