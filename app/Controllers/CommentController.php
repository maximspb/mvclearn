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
        $id = $this->request->addRequest('id');

        if (!empty($text) && !empty($username) && !empty($id)) {
            try {
                $comment = new Comment($id, $username, $text);
                $comment->save();
                header('Location:/news/read/?id='.$id);
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
