<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2/4/18
 * Time: 11:11 PM
 */

namespace App\Controllers;

use App\Database;
use App\Exceptions\NotFoundException;
use App\Models\News;

class NewsController extends Controller
{
    protected $templates =[];
    protected $news_id;

    public function __construct()
    {
        $this->templates['index'] = __DIR__.'/../Views/templates/index.php';
        $this->templates['article'] = __DIR__.'/../Views/templates/article.php';
        $this->templates['form'] = __DIR__.'/../Views/templates/editForm.php';


        $this->news_id =  $_GET['id'] ?? false;
    }

    public function actionIndex()
    {
        $news = News::findAll();
        include $this->templates['index'];
    }

    public function actionRead()
    {

        try {
            $article = News::findOne($this->news_id);
        } catch (NotFoundException $exception) {
                echo $exception->getMessage();
                exit(1);
        }
        ob_start();
        include $this->templates['article'];
        $view = ob_get_contents();
        ob_end_flush();
        return $view;
    }

    public function actionEdit()
    {
        $article = !empty($this->news_id) ? News::findOne($this->news_id) : new News();
        ob_start();
        include $this->templates['form'];
        ob_end_flush();
        if (isset($_POST['submit'])) :
            $article->title = $_POST['title'];
            $article->text = $_POST['text'];
            $article->save();
            header('Location:/index');
            exit();
        endif;
    }

    public function actionDelete()
    {
        if (!empty($this->news_id)) :
            try {
                News::delete($this->news_id);
                header('Location:/');
                exit();
            } catch (\Throwable $exception) {
                throw  new $exception('Ошибка удаления записи');
            }
        endif;
    }
}
