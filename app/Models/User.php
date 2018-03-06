<?php
namespace App\Models;

use App\BaseModel;
use App\Database;

class User extends BaseModel
{
    protected static $table = 'user';
    protected $email;
    protected $password;
    protected $name;

    protected static function allEmails()
    {
        $sql ='SELECT email from '. static::$table;
        return array_column(Database::getInstance()->query($sql), 'email');
    }

    protected static function getUserHash(string $email)
    {
        $sql ='SELECT password from '.static::$table.' WHERE email = :email';
        $options =[':email' => $email];
        return Database::getInstance()->query($sql, $options)[0]-> password;
    }

    public static function exists(string $email)
    {
        if (in_array($email, static::allEmails())) {
            return true;
        } else {
            return false;
        }
    }

    public static function check(string $email, string $password)
    {
        if (static::exists($email)) {
            if (password_verify($password, static::getUserHash($email))) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    public static function findByEmail(string $email)
    {
        $sql = 'SELECT * FROM '. static::$table.' WHERE email = :email';
        $options = [':email' => $email];
        return Database::getInstance()->query($sql, $options, static::class);
    }

    public function setPassword()
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }


    public function emailValidate(string $email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }


    public function passwordValidate(string $password)
    {
        if (preg_match('~[аяАЯ]~', $password)) {
            return false;
        }
        if (strlen($password) < 3) {
            return false;
        }
        return true;
    }

    public function nameValidate(string $name)
    {
        if (strlen($name) < 3) {
            return false;
        }
        return true;
    }
}
