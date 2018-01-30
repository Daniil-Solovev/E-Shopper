<?php

// Алиас для библиотеки Respect\Validation
use Respect\Validation\Validator as V;

class CabinetController
{
    // Проводит авторизацию и редиректит в кабинет
    public function actionIndex()
    {
        $userId = User::checkLogged();

        require_once (ROOT . '/views/cabinet/index.php');
        return true;
    }

    /**
     * @return bool
     * Валидация формы редактирования пользовательских данны
     */
    public function actionEdit()
    {
        $errors = [];
        $result = false;

        // Авторизация
        $userId = User::checkLogged();

        if (isset($_POST['submit'])) {
            $name = htmlspecialchars($_POST['name']);
            $password = $_POST['password'];

            // Валидаторы длинны поля
            $validateName = V::stringType();
            $isValidName = $validateName->length(3)->validate($name);
            $validatePassword = V::stringType();
            $isValidPassword = $validatePassword->length(6)->validate($password);

            if (!$isValidName) {
                $errors[] = 'Имя должно быть не менее 3-х символов';
            }

            if (!$isValidPassword) {
                $errors[] = 'Пароль должен быть не менее 6-ти символов';
            }

            if (empty($errors)) {
                $result = User::edit($userId, $name, $password);
            }
        }

        require_once (ROOT . '/views/cabinet/edit.php');
        return true;
    }
}