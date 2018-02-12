<?php

// Алиас для библиотеки Respect\Validation
use Respect\Validation\Validator as V;

class SiteController
{
    /**
     * @return bool
     * Вывод списка категорий и последних добавленых товаров (за счет сортировки DESC)
     */
    public function actionIndex()
    {
        $categories = [];
        $categories = Category::getCategoriesList();

        $latestProduct = [];
        $latestProduct = Product::getLatestProducts();

        $recommendedList = [];
        $recommendedList = Product::getRecommendedList();

        require_once (ROOT . '/views/site/index.php');
        return true;
    }

    /**
     * @return bool
     * Отправляет письмо админу
     */
    public function actionFeedback()
    {
        $result = false;
        $errors = [];

        if (isset($_POST['submit'])) {
            $message = $_POST['feedback'];
            $filePath = $_FILES['file']['tmp_name'];
            $fileName = $_FILES['file']['name'];

            // Перемещает загруженные файлы в корневую директорию.
            move_uploaded_file($filePath, ROOT . '/' . $fileName);

            if (isset($_SESSION['email'])) {
                $email = $_SESSION['email'];
            } else {
                $email = $_POST['email'];
            }

            $validateMessage = V::stringType();
            $isValidMessage = $validateMessage->length(6)->validate($message);
            $validateEmail = V::email();
            $isValidEmail = $validateEmail->validate($email);

            if (!$isValidMessage) {
                $errors[] = 'Введите сообщение';
            }

            if (!$isValidEmail) {
                $errors[] = 'Введите email';
            }

            if (empty($errors)) {
                User::sendMessage($email, $message, $fileName);
                $result = true;
            }
        }

        require_once (ROOT . '/views/site/feedback.php');
        return true;
    }
}