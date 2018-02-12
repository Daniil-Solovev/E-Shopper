<?php

class AdminCategoryController extends AdminBase
{
    /**
     * @return bool
     */
    public function actionIndex()
    {
        // Получает список ВСЕХ категорий
        $categoriesList = Category::getCategoriesListAdmin();

        require_once (ROOT . '/views/admin_category/index.php');
        return true;
    }

    /**
     * @return bool
     */
    public function actionCreate()
    {
        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $sort_order = $_POST['sort_order'];
            $status = $_POST['status'];

            // При необходимости - добавить валидацию
            $errors = false;

            // Если нет ошибок - создает категорию
            if ($errors == false) {
                Category::createCategory($name, $sort_order, $status);

                header("Location: /admin/category");
            }
        }
        require_once (ROOT . '/views/admin_category/create.php');
        return true;
    }

    /**
     * @param $id
     * @return bool
     */
    public function actionUpdate($id)
    {
        // Получает категорию по ID
        $category = Category::getCategoryById($id);

        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $sort_order = $_POST['sort_order'];
            $status = $_POST['status'];

            // Обновляет категорию
            Category::updateCategoryById($id, $name, $sort_order, $status);

            header("Location: /admin/category");
        }
        require_once (ROOT . '/views/admin_category/update.php');
        return true;
    }

    /**
     * @param $id
     * @return bool
     */
    public function actionDelete($id)
    {
        if (isset($_POST['submit'])) {
            // Удаляет категорию
            Category::deleteCategoryById($id);

            header("Location: /admin/category");
        }
        require_once (ROOT . '/views/admin_category/delete.php');
        return true;
    }
}