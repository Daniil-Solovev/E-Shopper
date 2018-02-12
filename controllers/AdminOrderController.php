<?php

class AdminOrderController extends AdminBase
{
    /**
     * @return bool
     */
    public function actionIndex()
    {
        // Получаем список заказов
        $ordersList = Order::getOrdersList();

        // Подключаем вид
        require_once(ROOT . '/views/admin_order/index.php');
        return true;
    }

    /**
     * @param $id
     * @return bool
     */
    public function actionUpdate($id)
    {
        // Получает данные о конкретном заказе
        $order = Order::getOrderById($id);

        // Обработка формы
        if (isset($_POST['submit'])) {

            $userName = $_POST['userName'];
            $userPhone = $_POST['userPhone'];
            $userComment = $_POST['userComment'];
            $date = $_POST['date'];
            $status = $_POST['status'];

            // Сохраняет изменения
            Order::updateOrderById($id, $userName, $userPhone, $userComment, $date, $status);

            // Перенаправляем пользователя на страницу управлениями заказами
            header("Location: /admin/order/view/$id");
        }

        require_once(ROOT . '/views/admin_order/update.php');
        return true;
    }

    /**
     * @param $id
     * @return bool
     */
    public function actionView($id)
    {
        // Получает данные о конкретном заказе
        $order = Order::getOrderById($id);
        // Получает список заказов из БД
        $productsQuantity = json_decode($order['products'], true);
        // Возвращает массив ключей от списка заказов
        $productsIds = array_keys($productsQuantity);
        // Получает список товаров по ключам
        $products = Product::getProductsByIds($productsIds);

        require_once (ROOT . '/views/admin_order/view.php');
        return true;
    }

    /**
     * @param $id
     */
    public function actionDelete($id)
    {
        if (isset($_POST['submit'])) {
            // Удаляет заказ
            Order::deleteOrderById($id);
            header("Location: /admin/order");
        }
    }
}