<?php

class Product
{
    // Определяет количество отображаемых элементов по умолчанию
    const SHOW_BY_DEFAULT = 6;

    /**
     * @param int $count
     * @return array
     * Выводит последние добавленные товары
     */
    public static function getLatestProducts($count = self::SHOW_BY_DEFAULT) {

        $count = intval($count);
        $db = Db::getConnection();
        $productsList = [];

        $result = $db->query("SELECT id, name, price, image, is_new FROM product 
                                      WHERE status = '1' AND brand <> 'Name' ORDER BY id DESC LIMIT " . $count);
        $productsList = $result->fetchAll();
        return $productsList;
    }

    /**
     * @return array
     * Возвращает список продуктов
     */
    public static function getProductsList()
    {
        $db = Db::getConnection();
        $result = $db->query('SELECT id, name, price, code FROM product ORDER BY id ASC');

        $productsList = [];
        $productsList = $result->fetchAll();

        return $productsList;
    }

    /**
     * @param bool $categoryId
     * @param int $page
     * @return array
     * Возвращает список товаров согласно заданой категории
     */
    public static function getProductsListByCategory($categoryId = false, $page = 1)
    {
        if ($categoryId) {
            $page = intval($page);
            $offset = ($page - 1) * self::SHOW_BY_DEFAULT;

            $db = Db::getConnection();
            $products = [];
            $result = $db->query("SELECT id, name, price, image, is_new FROM product "
                                          . "WHERE status = '1' AND category_id = ". $categoryId
                                          . " ORDER BY id ASC "
                                          . "LIMIT ".self::SHOW_BY_DEFAULT
                                          . " OFFSET " . $offset);
            $products = $result->fetchAll();
            return $products;
        }
    }

    /**
     * @param $id
     * @return mixed
     * Возвращает элемент по его id
     */
    public static function getProductById($id)
    {
        $id = intval($id);
        $products = [];

        if ($id) {
            $db = Db::getConnection();

            $result = $db->prepare('SELECT * FROM product WHERE id = ?');
            $result->execute(array($id));
            $products = $result->fetchAll();


            return $products;
        }
    }

    /**
     * @param $categoryId
     * @return mixed
     * Возвращает все элементы одной категории для определения количества кнопок пагинатора
     */
    public static function getTotalProductsInCategory($categoryId)
    {
        $db = Db::getConnection();

        $result = $db->query('SELECT count(id) AS count FROM product '
                                      . 'WHERE status = "1" AND category_id = '. $categoryId);
        $row = $result->fetch();

        return $row['count'];
    }

    /**
     * @param $idsArray
     * @return array
     * Возвращает товар по id
     */
    public static function getProductsByIds($idsArray)
    {
        $products = [];
        $db = Db::getConnection();

        $idsString = implode(',', $idsArray);

        $sql = "SELECT * FROM product WHERE status = 1 AND id IN ($idsString)";
        $result = $db->query($sql);
        $products = $result->fetchAll();

        return $products;
    }

    /**
     * @param int $count
     * @return array|PDOStatement
     * Возвращает список рекомендуемых товаров (для слайдера)
     */
    public static function getRecommendedList($count = self::SHOW_BY_DEFAULT)
    {
        $recommendedProducts = [];
        $db = Db::getConnection();

        $result = $db->query('SELECT id, name, price, image, is_new FROM product WHERE status = 1
                                      AND is_recommended = 1 LIMIT ' . $count);
        $result = $result->fetchAll();

        return $result;
    }

    /**
     * @param $id
     * @return bool
     * Удаляет товар по его id
     */
    public static function deleteProductById($id)
    {
        $db = Db::getConnection();
        $sql = "DELETE FROM product WHERE id = :id";

        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        return $result->execute();
    }

    /**
     * @param $options
     * @return int|string
     * Добавляет товар в БД
     */
    public static function createProduct($options)
    {
        $db = Db::getConnection();
        $sql = 'INSERT INTO product (name, code, price, category_id, brand, 
                availability, description, is_new, is_recommended, status) 
                VALUES (:name, :code, :price, :category_id, :brand, :availability, 
                :description, :is_new, :is_recommended, :status)';

        $result = $db->prepare($sql);
        $result->bindParam(':name', $options['name'], PDO::PARAM_STR);
        $result->bindParam(':code', $options['code'], PDO::PARAM_STR);
        $result->bindParam(':price', $options['price'], PDO::PARAM_STR);
        $result->bindParam(':category_id', $options['category_id'], PDO::PARAM_INT);
        $result->bindParam(':brand', $options['brand'], PDO::PARAM_STR);
        $result->bindParam(':availability', $options['availability'], PDO::PARAM_INT);
        $result->bindParam(':description', $options['description'], PDO::PARAM_STR);
        $result->bindParam(':is_new', $options['is_new'], PDO::PARAM_INT);
        $result->bindParam(':is_recommended', $options['is_recommended'], PDO::PARAM_INT);
        $result->bindParam(':status', $options['status'], PDO::PARAM_INT);
        if ($result->execute()) {
            return $db->lastInsertId();
        }

        return 0;
    }

    /**
     * @param $id
     * @param $options
     * @return bool
     * Обновляет данные товара по его id
     */
    public static function updateProductById($id, $options)
    {
        $db = Db::getConnection();
        $sql = 'UPDATE product SET
                name = :name,
                code = :code,
                price = :price,
                category_id = :category_id,
                brand = :brand,
                availability = :availability,
                description = :description,
                is_new = :is_new,
                is_recommended = :is_recommended,
                status = :status 
                WHERE id = :id';

        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':name', $options['name'], PDO::PARAM_STR);
        $result->bindParam(':code', $options['code'], PDO::PARAM_STR);
        $result->bindParam(':price', $options['price'], PDO::PARAM_STR);
        $result->bindParam(':category_id', $options['category_id'], PDO::PARAM_INT);
        $result->bindParam(':brand', $options['brand'], PDO::PARAM_STR);
        $result->bindParam(':availability', $options['availability'], PDO::PARAM_INT);
        $result->bindParam(':description', $options['description'], PDO::PARAM_STR);
        $result->bindParam(':is_new', $options['is_new'], PDO::PARAM_INT);
        $result->bindParam(':is_recommended', $options['is_recommended'], PDO::PARAM_INT);
        $result->bindParam(':status', $options['status'], PDO::PARAM_INT);
        return $result->execute();
    }

    /**
     * @param $id
     * @return string
     * Проверяет существование файла - изображения
     */
    public static function getImage($id)
    {
        // Название изображения-пустышки
        $noImage = 'no-image.jpg';

        // Путь к папке с товарами
        $path = '/template/images/upload/';

        // Путь к изображению товара
        $pathToProductImage = $path . $id . '.jpg';

        if (file_exists(ROOT . $pathToProductImage)) {
            // Если изображение для товара существует
            // Возвращаем путь изображения товара
            return $pathToProductImage;
        }

        // Возвращаем путь изображения-пустышки
        return $path . $noImage;
    }

}