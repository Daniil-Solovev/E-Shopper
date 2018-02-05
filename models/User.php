<?php

class User
{
    /**
     * @param $name
     * @param $email
     * @param $password
     * @return bool
     * Добавляет нового пользователя в БД
     */
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

    /**
     * @param $email
     * @return bool
     * Проверяет наличие в БД пользователя с аналогичным email
     */
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

    /**
     * @param $email
     * @param $password
     * @return bool
     * Ищет пользователя и проводит аутентификацию
     */
    public static function checkUserData($email, $password)
    {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM user WHERE email = :email';

        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->execute();

        $user = $result->fetch();
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;

    }

    /**
     * @param $userData
     * Стартует сессию с id пользователя
     */
    public static function auth($userData)
    {
        $_SESSION['user'] = $userData['id'];
        $_SESSION['email'] = $userData['email'];
    }

    /**
     * @return mixed
     * Авторизация
     */
    public static function checkLogged()
    {
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }

        header("Location: /user/login");
    }

    /**
     * @return bool
     * Авторизация
     */
    public static function isGuest()
    {
        if (isset($_SESSION['user'])) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @param $id
     * @param $name
     * @param $password
     * @return bool
     * Редактирование пользовательских данных
     */
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

    public static function sendMessage($email, $textMessage, $fileName = null)
    {
        // Конфигурация траспорта
        $transport = (new Swift_SmtpTransport('smtp.mail.ru', 465, 'ssl'))
            ->setUsername('doingsdone@mail.ru')
            ->setPassword('rds7BgcL')
        ;

        $text = $textMessage;

        // Формирование сообщения
        $message = new Swift_Message("Оповещение о задачах");
        $message->setTo(["frontend.servise@gmail.com" => "Администратор"]);
        $message->setBody("$text");
        $message->setFrom("doingsdone@mail.ru", "$email");

        // Добавление файлов
        if (isset($fileName)) {
            $path = ROOT . '/' . $fileName;
            $path = str_replace('\\', '/', $path);
            $message->attach(
                Swift_Attachment::fromPath($path)
            );
        }

        // Отправка сообщения
        $mailer = new Swift_Mailer($transport);
        $mailer->send($message);
    }
}