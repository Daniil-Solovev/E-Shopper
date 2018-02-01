<?php

// Алиас для библиотеки Respect\Validation
use Respect\Validation\Validator as V;

class UserController
{
    /**
     * @return bool
     * Валидация полей регистрации
     */
    public function actionRegister()
    {
        $name = '';
        $email = '';
        $password = '';
        $errors = [];
        $result = false;


        if (isset($_POST['submit'])) {
            $name = htmlspecialchars($_POST['name']);
            $email = htmlspecialchars($_POST['email']);
            $password = $_POST['password'];

            // Валидаторы длины поля и корректности email
            $validateName = V::stringType();
            $isValidName = $validateName->length(3)->validate($name);
            $validateEmail = V::email();
            $isValidEmail = $validateEmail->validate($email);
            $validatePassword = V::stringType();
            $isValidPassword = $validatePassword->length(6)->validate($password);

            if (!$isValidName) {
                $errors[] = 'Имя должно быть не менее 3-х символов';
            }

            if (!$isValidEmail) {
                $errors[] = 'Email указан неверно';
            }

            if (!$isValidPassword) {
                $errors[] = 'Пароль должен быть не менее 6-ти символов';
            }

            if (User::checkEmailExists($email)) {
                $errors[] = 'Такой email уже используется';
            }

            if (empty($errors)) {
                $result = User::register($name, $email, $password);
            }
        }

        require_once (ROOT . '/views/user/register.php');
        return true;
    }

    /**
     * @return bool
     * Валидация полей входа. Редирект в личный кабинет
     */
    public function actionLogin()
    {
        $email = '';
        $password = '';
        $errors = [];

        if (isset($_POST['submit'])) {
            $email = htmlspecialchars($_POST['email']);
            $password = $_POST['password'];

            $validateEmail = V::email();
            $isValidEmail = $validateEmail->validate($email);
            $validatePassword = V::stringType();
            $isValidPassword = $validatePassword->length(6)->validate($password);

            if (!$isValidEmail) {
                $errors[] = 'Email указан неверно';
            }

            if (!$isValidPassword) {
                $errors[] = 'Пароль должен быть не менее 6-ти символов';
            }

            $userData= User::checkUserData($email, $password);
            if (empty($userData)) {
                $errors[] = 'Неправильные данные для входа на сайт';
            } else {
                User::auth($userData);
                header("Location: /cabinet/");
            }
        }
        require_once (ROOT . '/views/user/login.php');
        return true;
    }

    /**
     * Logout
     */
    public function actionLogout()
    {
        unset($_SESSION['user']);
        header("Location: /");
    }
}