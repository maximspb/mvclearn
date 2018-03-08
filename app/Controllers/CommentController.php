<?php
namespace App\Controllers;

use App\Models\Comment;
use App\Exceptions\MultiException;
use App\Exceptions\DeleteCommentException;

class CommentController extends Controller
{
    public function actionCreate()
    {
        $newsId = $this->request->getRequestVars('newsId');
        try {
            $comment = new Comment();
            $comment->fill($this->request->allValues());
            $comment->save();
            unset($_SESSION['errorsExist']);
            header('Location:/news/read/?id='.$newsId);
        } catch (MultiException $e) {
            if (!empty($e)) {
                $_SESSION['errorsExist'] = true;
            }
            header('Location:/news/read/?id='.$newsId);
        }
    }


    public function actionDelete()
    {
        $commentId = $this->request->getRequestVars('commentId');
        $articleId = $this->request->getRequestVars('articleId');
        try {
            Comment::delete($commentId);
            header('Location:/news/read/?id='.$articleId);
        } catch (\Throwable $exception) {
            throw new DeleteCommentException();
        }
    }
}
