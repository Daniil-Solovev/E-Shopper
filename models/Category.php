<?php

class Category
{
    /**
     * Выводит список категорий
     * @return array
     */
    public static function getCategoriesList()
    {
        $db = Db::getConnection();
        $categoryList = [];

        $result = $db->query('SELECT * FROM category WHERE status = 1 ORDER BY sort_order ASC');

        $categoryList = $result->fetchAll();
        return $categoryList;
    }

    /**
     * @return array
     * Возвращает список ВСЕХ категорий
     */
    public static function getCategoriesListAdmin()
    {
        $db = Db::getConnection();
        $categoryList = [];

        $result = $db->query('SELECT id, name, sort_order, status FROM category ORDER BY sort_order ASC');

        $categoryList = $result->fetchAll();
        return $categoryList;
    }

    /**
     * @param $id
     * @return bool
     * Удаляет категорию по id
     */
    public static function deleteCategoryById($id)
    {
        $db = Db::getConnection();
        $sql = 'DELETE FROM product WHERE id = :id';
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        return $result->execute();
    }

    /**
     * @param $id
     * @param $name
     * @param $sort_order
     * @param $status
     * @return bool
     * Обновляет категорию по id
     */
    public static function updateCategoryById($id, $name, $sort_order, $status)
    {
        $db = Db::getConnection();
        $sql = 'UPDATE product SET 
                name = :name,
                sort_order = :sort_order,
                status = :status
                WHERE id = :id';
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':status', $status, PDO::PARAM_INT);
        $result->bindParam(':sort_order', $sort_order, PDO::PARAM_INT);
        return $result->execute();
    }

    /**
     * @param $id
     * @return mixed
     * Возвращает категорию по id
     */
    public static function getCategoryById($id)
    {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM category WHERE id = :id';

        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->execute();
        return $result->fetch();
    }

    /**
     * @param $name
     * @param $sort_order
     * @param $status
     * @return bool
     * Создает категорию
     */
    public static function createCategory($name, $sort_order, $status)
    {
        $db = Db::getConnection();
        $sql = 'INSERT INTO category (name, sort_order, status) VALUES (:name, :sort_order, :status)';

        $result = $db->prepare($sql);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':status', $status, PDO::PARAM_INT);
        $result->bindParam(':sort_order', $sort_order, PDO::PARAM_INT);
        return $result->execute();
    }
}