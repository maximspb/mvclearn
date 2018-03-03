<?php
namespace App\Controllers;

use App\Application;
use App\Models\User;
use App\Exceptions\MultiException;

class UserController extends Controller
{
    public function actionCreate()
    {
        $email = Application::getRequest('email');
        if (!User::exists($email)) {
            try {
                $user = new User();
                $user->fill(Application::getMultiple());
                $user->setPassword();
                $user->save();
                header('Location:/news');
            } catch (MultiException $exception) {
                $errors = $exception->getAllErrors();
                $this->view->display('register.twig', ['errors' => $errors]);
            } catch (\Throwable $e) {
                echo $e->getMessage();
                exit(1);
            }
        } else {
            $userExists = true;
            $this->view->display('register.twig', ['userExists' => $userExists]);
        }
    }

    public function actionRegister()
    {
        $this->view->display('register.twig');
    }

    public function actionLogin()
    {
        $logged = $_SESSION['logged'] ?? false;
        if ($logged) {
            header('Location:/news');
        }
        $this->view->display('login.twig');
    }

    public function actionAuth()
    {
        $email = Application::getRequest('email');
        $password = Application::getRequest('password');
        if (User::check($email, $password)) {
            $_SESSION['logged'] = User::findByEmail($email)[0]->getName();
            header('Location:/news');
        } else {
            $authErrors = true;
            $this->view->display('login.twig', ['authErrors' => $authErrors]);
        }
    }

    public function actionLogout()
    {
        unset($_SESSION['logged']);
        session_destroy();
        header('Location:/news');
    }
}