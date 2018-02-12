<?php

abstract class AdminBase
{
    // Вызывет проверку доступа
    public function __construct()
    {
        $this->checkAdmin();
    }

    /**
     * @return bool
     *  Проверяет, есть ли у пользователя админ - права (role == admin)
     */
    public function checkAdmin()
    {
        $userId = User::checkLogged();
        $user = false;

        if ($userId) {
            $user = $_SESSION['role'];
        }

        if ($user == 'admin') {
            return true;
        }

        die('Access denied');
    }
}