<?php

// Алиас для библиотеки Respect\Validation
use Respect\Validation\Validator as V;

class CartController
{
    // Переадресация на исходную страницу после добавления товара в корзину
    public function actionAdd($id)
    {
        // Добавляет товар в корзину
        Cart::addProduct($id);

        // Возвращаем пользователя на страницу
        $referrer = $_SERVER['HTTP_REFERER'];
        header("Location: $referrer");
    }


    public function actionAddAjax($id)
    {
        // Добавляет товар в корзину
        echo Cart::addProduct($id);
        return true;
    }


    // Вывод добавленных товаров в корзину
    public function actionIndex()
    {
        $categories = [];
        $categories = Category::getCategoriesList();

        $productsInCart = false;
        $productsInCart = Cart::getProducts();

        if ($productsInCart) {
            $productsIds = array_keys($productsInCart);
            $products = Product::getProductsByIds($productsIds);

            // Получить общую стоимость товара
            $totalPrice = Cart::getTotalPrice($products);
        }
        require_once (ROOT . '/views/cart/index.php');
        return true;
    }

    // Подтверждение покупки
    public function actionCheckout()
    {
        $categories = [];
        $categories = Category::getCategoriesList();

        $result = false;

        // Если форма отправлена
        if (isset($_POST['submit'])) {
            $userName = $_POST['userName'];
            $userPhone = $_POST['userPhone'];
            $userComment = $_POST['userComment'];

            $errors = [];

            // Валидация
            $validateName = V::stringType();
            $isValidName = $validateName->length(3)->validate($userName);
            $validatePhone = V::phone();
            $isValidPhone = $validatePhone->length(11)->validate($userPhone);
            $validateComment = V::stringType();
            $isValidComment = $validateComment->length(6)->validate($userComment);

            if (!$isValidName) {
                $errors[] = 'Имя должно быть не менее 3-х символов';
            }

            if (!$isValidPhone) {
                $errors[] = 'Некорректно указан номер телефона';
            }

            if (!$isValidComment) {
                $errors[] = 'Сообщение должно быть не короче 6-ти символов';
            }

            // Если ошибок нет - сохраняем результат в БД
            if (empty($errors)) {
                $productsInCart = Cart::getProducts();
                if (User::isGuest()) {
                    $userId = null;
                } else {
                    $userId = User::checkLogged();
                }

                $result = Order::save($userName, $userPhone, $userComment, $userId, $productsInCart);

                // Отправляем сообщение о заказе администратору, очищаем корзину
                if ($result) {
                    $email = $_SESSION['email'];
                    $message = 'Имя: ' . $userName . '; ' . 'id: ' . $userId . '; ' . 'Телефон: ' . $userPhone . ';' . 'Сообщение: ' . $userComment;
                    User::sendMessage($email, $message);

                    Cart::clear();
                }

            // Если в форме есть ошибки
            } else {
                $productsInCart = Cart::getProducts();
                $productsIds = array_keys($productsInCart);
                $products = Product::getProductsByIds($productsIds);
                $totalPrice = Cart::getTotalPrice($products);
                $totalQuantity = Cart::countItems();
            }
        // Если форма не отправлена
        } else {
            $productsInCart = Cart::getProducts();
            // Если в корзине нет товаров
            if (!$productsInCart) {
                header("Location: /");
            } else {
                $productsIds = array_keys($productsInCart);
                $products = Product::getProductsByIds($productsIds);
                $totalPrice = Cart::getTotalPrice($products);
                $totalQuantity = Cart::countItems();

                $userName = false;
                $userPhone = false;
                $userComment = false;

            }
        }
        require_once (ROOT. '/views/cart/checkout.php');
        return true;
    }

    // Удаляет товар из корзины

    public function actionDelete($id)
    {
        Cart::deleteProduct($id);

        header("Location: /cart");
    }
}