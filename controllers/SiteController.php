<?php

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

        require_once (ROOT . '/views/site/index.php');
        return true;
    }
}