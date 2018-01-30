<?php

class User
{
    public static function register($name, $email, $password)
    {
        $db = Db::getConnection();
        $passhash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO user (name, email, password, role) VALUES (:name, :email, :password, 'user')";
        $result = $db->prepare($sql);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':password', $passhash, PDO::PARAM_STR);

        return $result->execute();
    }

    public static function checkEmailExists($email)
    {
        $db = Db::getConnection();

        $sql = 'SELECT COUNT(*) FROM user WHERE email = :email';

        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->execute();

        if ($result->fetchColumn())
            return true;
        return false;
    }

    public static function checkUserData($email, $password)
    {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM user WHERE email = :email';

        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->execute();

        $user = $result->fetch();
        if ($user && password_verify($password, $user['password'])) {
            return $user['id'];
        }

        return false;

    }

    public static function auth($userId)
    {
        $_SESSION['user'] = $userId;
    }

    public static function checkLogged()
    {
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }

        header("Location: /user/login");
    }

    public static function isGuest()
    {
        if (isset($_SESSION['user'])) {
            return false;
        } else {
            return true;
        }
    }

    public static function edit($id, $name, $password)
    {
        $db = Db::getConnection();
        $passhash = password_hash($password, PASSWORD_DEFAULT);

        $sql = 'UPDATE user SET name = :name, password = :password WHERE id = :id';
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_STR);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':password', $passhash, PDO::PARAM_STR);
        return $result->execute();
    }
}