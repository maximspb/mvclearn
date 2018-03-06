<?php

namespace App;

use Twig_Environment;
use Twig_Loader_Filesystem;
use App\Traits\MagicSetTrait;

class View
{
    use MagicSetTrait;
    protected $twig;
    public function __construct()
    {
        $templatesPath = Config::getInstance()->getParams()['templates']['path'];
        $cache = Config::getInstance()->getParams()['cache']['twig'];
        $loader = new Twig_Loader_Filesystem($templatesPath);
        $this->twig = new Twig_Environment($loader, [
            'cache' => $cache,
            'debug'=>true
            ]);
        $logged =!empty($_SESSION['logged']) ? true : false;
        $this->twig->addGlobal('logged', $logged);
    }

    public function display(string $template, array $params = [])
    {
        try {
            $this->twig->display($template, $params);
        } catch (\Exception|\Throwable $e) {
            echo $e->getMessage();
            exit(1);
        }
    }

    public function twig()
    {
        return $this->twig;
    }
}
