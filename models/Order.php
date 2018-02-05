<?php

class Order
{
    /**
     * @param $userName
     * @param $userPhone
     * @param $userComment
     * @param $userId
     * @param $products
     * @return bool
     * Сохранение заказа
     */
    public static function save($userName, $userPhone, $userComment, $userId, $products)
    {
        $db = Db::getConnection();
        $sql = 'INSERT INTO product_order (user_name, user_phone, user_comment, user_id, products) 
                VALUES (:username, :userphone, :usercomment, :userid, :products)';

        $products = json_encode($products);

        $result = $db->prepare($sql);
        $result->bindParam(':username', $userName, PDO::PARAM_STR);
        $result->bindParam(':userphone', $userPhone, PDO::PARAM_STR);
        $result->bindParam(':usercomment', $userComment, PDO::PARAM_STR);
        $result->bindParam(':userid', $userId, PDO::PARAM_STR);
        $result->bindParam(':products', $products, PDO::PARAM_STR);
        return $result->execute();
    }
}