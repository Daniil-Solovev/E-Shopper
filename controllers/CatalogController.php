<?php

class CatalogController
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

        require_once (ROOT . '/views/catalog/index.php');

        return true;
    }

    /**
     * @param $categoryId
     * @param int $page
     * @return bool
     * Вывод списка категорий
     * Вывод товаров по id категории
     * Запрос общего списка товаров в категории и вывод пагинатора
     */
    public function actionCategory($categoryId, $page = 1)
    {
        $categories = [];
        $categories = Category::getCategoriesList();

        $categoryProducts = [];
        $categoryProducts = Product::getProductsListByCategory($categoryId, $page);

        $total = Product::getTotalProductsInCategory($categoryId);

        $pagination = new Pagination($total, $page, Product::SHOW_BY_DEFAULT, 'page-');

        require_once (ROOT . '/views/catalog/category.php');
        return true;
    }
}