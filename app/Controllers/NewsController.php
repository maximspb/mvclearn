<?php

namespace App\Controllers;

use App;
use App\Models\News;
use App\Models\Comment;
use App\Exceptions\MultiException;
use App\Exceptions\NotFoundException;

class NewsController extends Controller
{
    public function actionIndex()
    {
        $news = News::findAll();
        $this->view->display('news.twig', ['news' => $news]);
    }

    public function actionRead()
    {
        $session  = $_SESSION;
        $id = strip_tags($this->request->getRequestVars('id'));
        $comments = Comment::findNewsComments($id) ?? [];

        try {
            $article = News::findOne($id);
            $this->view->display('article.twig', [
                'article' => $article,
                'comments' => $comments,
                'session' => $session,
            ]);
        } catch (NotFoundException|App\Exceptions\DeleteCommentException $exception) {
                echo $exception->getMessage();
                exit(1);
        }
    }

    public function actionEdit()
    {
        $id = strip_tags($this->request->getRequestVars('id'));
        try {
            $article = !empty($id) ? News::findOne($id) : new News();
        } catch (NotFoundException $exception) {
            echo $exception->getMessage();
            exit(1);
        }
        $this->view->display('editForm.twig', ['article' =>  $article]);
    }

    public function actionSave()
    {
        $id = strip_tags($this->request->allValues()['id']);
        $article = !empty($id) ? News::findOne($id) : new News();
        try {
            $article->fill($this->request->allValues());
            $article->save();
            header('Location:/news');
            exit();

        } catch (MultiException $e) {
            $articleErrors = $e->getAllErrors();
            $this->view->display('editForm.twig', [
                'article' => $article,
                'articleErrors' => $articleErrors
            ]);
        }
    }

    public function actionDelete()
    {
        $id = strip_tags($this->request->getRequestVars('id'));
        if (!empty($id)) {
            try {
                News::delete(strip_tags($id));
                header('Location:/');
                exit();
            } catch (\Throwable $exception) {
                throw  new $exception();
            }
        }
    }
}
