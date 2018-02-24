<?php

namespace App\Controllers;

use App\Exceptions\EditException;
use App\Exceptions\NotFoundException;
use App\Models\Comment;
use App\Models\News;

class NewsController extends Controller
{

    protected $news_id;
    public function __construct()
    {
        parent::__construct();
        $this->news_id =  $this->request->addRequest('id');
    }

    public function actionIndex()
    {
        $this->view->news = News::findAll();
        $this->view->display('news.twig', $this->view->getData());
    }

    public function actionRead()
    {
        try {
            $this->view->article = News::findOne(strip_tags($this->news_id));
        } catch (NotFoundException $exception) {
                echo $exception->getMessage();
                exit(1);
        }
        $this->view->comments = Comment::findArticleComments([':id'=>$this->news_id]);
        $this->view->display('article.twig', $this->view->getData());
    }

    public function actionEdit()
    {
        $id = $this->news_id;
        $this->view->article = !empty($id) ? News::findOne(strip_tags($id)) : new News();
        $this->view->display('editForm.twig', $this->view->getData());
    }

    public function actionSave()
    {
        $id = $this->news_id;
        $article = !empty($id) ? News::findOne(strip_tags($id)) : new News();
        $title = $this->request->addRequest('title');
        $text = $this->request->addRequest('text');
        try {
            $article->title = strip_tags($title);
            $article->text = strip_tags($text);
            $article->save();
            header('Location:/news');
            exit();

        } catch (\Throwable $e) {
            throw new EditException();
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
                throw  new $exception('Ошибка удаления записи');
            }
        }
    }
}
