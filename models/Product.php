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

        if ($id) {
            $db = Db::getConnection();

            $result = $db->prepare('SELECT * FROM product WHERE id = ?');
            $result->execute(array($id));

           $products = [];
            $i = 0;
            while ($row = $result->fetch()) {
                $products[$i]['id'] = $row['id'];
                $products[$i]['name'] = $row['name'];
                $products[$i]['code'] = $row['code'];
                $products[$i]['price'] = $row['price'];
                $products[$i]['image'] = $row['image'];
                $products[$i]['brand'] = $row['brand'];
                $products[$i]['description'] = $row['description'];
                $i++;
            }

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

    public static function getRecommendedList($count = self::SHOW_BY_DEFAULT)
    {
        $recommendedProducts = [];
        $db = Db::getConnection();

        $result = $db->query('SELECT id, name, price, image FROM product WHERE status = 1
                                      AND is_recommended = 1 LIMIT ' . $count);
        $result = $result->fetchAll();

        return $result;
    }

}