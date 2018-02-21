<?php

namespace App;

use App\Traits\MagicSetTrait;
use Twig_Loader_Filesystem;
use Twig_Environment;

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
}
