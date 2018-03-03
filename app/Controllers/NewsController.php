<?php

namespace App\Controllers;

use App;
use App\Models\News;
use App\Application;
use App\Models\Comment;
use App\Exceptions\MultiException;
use App\Exceptions\NotFoundException;

class NewsController extends Controller
{

    protected $news_id;
    public function __construct()
    {
        parent::__construct();
        $this->news_id = Application::getRequest('id');
    }

    public function actionIndex()
    {
        $news = News::findAll();
        $this->view->display('news.twig', ['news' => $news]);
    }

    public function actionRead()
    {
        $session  = $_SESSION;

        try {
            $article = News::findOne(strip_tags($this->news_id));

        } catch (NotFoundException $exception) {
                echo $exception->getMessage();
                exit(1);
        }
        $comments = Comment::findNewsComments(strip_tags($this->news_id));
        $this->view->display('article.twig', [
            'article' => $article,
            'comments' => $comments,
            'session' => $session,
        ]);
    }

    public function actionEdit()
    {
        $id = $this->news_id;
        try {
            $article = !empty($id) ? News::findOne(strip_tags($id)) : new News();
        } catch (NotFoundException $exception) {
            echo $exception->getMessage();
            exit(1);
        }
        $this->view->display('editForm.twig', ['article' =>  $article]);
    }

    public function actionSave()
    {
        $id = $this->news_id;
        $article = !empty($id) ? News::findOne(strip_tags($id)) : new News();
        try {
            $article->fill(Application::getMultiple());
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
        if (!empty(strip_tags($this->news_id))) {
            try {
                News::delete(strip_tags($this->news_id));
                header('Location:/');
                exit();
            } catch (\Throwable $exception) {
                throw  new $exception();
            }
        }
    }
}
