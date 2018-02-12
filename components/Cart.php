<?php

class Cart
{
    /**
     * @param $id
     * @return int
     * Добавляет товар в корзину и проверяет его наличие
     */
    public static function addProduct($id)
    {
        $id = intval($id);

        // Пустой массив для товаров в корзине
        $productsInCart = [];

        // Проверяет, есть ли в корзине товары
        if (isset($_SESSION['products'])) {
            $productsInCart = $_SESSION['products'];
        }

        // Если товар есть в корзине, но был добавлен еще раз - увеличиваем количество
        if (array_key_exists($id, $productsInCart)) {
            $productsInCart[$id]++;
        } else {
            $productsInCart[$id] = 1;
        }

        $_SESSION['products'] = $productsInCart;
        return self::countItems();
    }

    /**
     * @return int
     * Общее количество товаров в корзине
     */
    public static function countItems()
    {
        if (isset($_SESSION['products'])) {
            $count = 0;
            foreach ($_SESSION['products'] as $id => $quantity) {
                $count = $count + $quantity;
            }
            return $count;
        } else {
            return 0;
        }
    }

    /**
     * @return bool
     * Устанавливает сессию products, если еще не установлена
     */
    public static function getProducts()
    {
        if (isset($_SESSION['products'])) {
            return $_SESSION['products'];
        }
        return false;
    }

    /**
     * @param $products
     * @return int
     * Возвращает общую сумму товаров в корзине
     */
    public static function getTotalPrice($products)
    {
        $productsInCart = self::getProducts();

        if ($productsInCart) {
            $total = 0;
            foreach ($products as $item) {
                $total += $item['price'] * $productsInCart[$item['id']];
                
            }
        }
        return $total;
    }

    /**
     * Очищает корзину
     */
    public static function clear()
    {
        if (isset($_SESSION['products'])) {
            unset($_SESSION['products']);
        }
    }

    /**
     * @param $id
     * Удаляет товар из корзины
     */
    public static function deleteProduct($id)
    {
        $productsInCart = self::getProducts();

        unset($productsInCart[$id]);

        $_SESSION['products'] = $productsInCart;
    }
}