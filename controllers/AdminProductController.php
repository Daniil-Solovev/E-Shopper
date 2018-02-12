<?php

class AdminProductController extends AdminBase
{
    /**
     * @return bool
     */
    public function actionIndex()
    {
        // Получает список всех товаров
        $productsList = Product::getProductsList();

        require_once (ROOT . '/views/admin_product/index.php');
        return true;
    }

    /**
     * @param $id
     * @return bool
     */
    public function actionDelete($id)
    {
        if (isset($_POST['submit'])) {
            // Удаляет товар по id
            Product::deleteProductById($id);

            header("Location: /admin/product");
        }

        require_once (ROOT . '/views/admin_product/delete.php');
        return true;
    }

    /**
     * @return bool
     */
    public function actionCreate()
    {
        // Получает список ВСЕХ категорий
        $categoriesList = Category::getCategoriesListAdmin();

        if (isset($_POST['submit'])) {
            $options['name'] = $_POST['name'];
            $options['code'] = $_POST['code'];
            $options['price'] = $_POST['price'];
            $options['category_id'] = $_POST['category_id'];
            $options['brand'] = $_POST['brand'];
            $options['availability'] = $_POST['availability'];
            $options['description'] = $_POST['description'];
            $options['is_new'] = $_POST['is_new'];
            $options['is_recommended'] = $_POST['is_recommended'];
            $options['status'] = $_POST['status'];

            // Возможно добавление валидации
            $errors = [];

            if ($errors == false) {
                // Создает товар, если ошибок в форме нет
                $id = Product::createProduct($options);

                if ($id) {
                    // Если товар создан - проверяет загрузку изображения
                    if (is_uploaded_file($_FILES['image']['tmp_name'])) {
                        $filePath = $_FILES['image']['tmp_name'];

                        // Перемещает загруженные файлы в корневую директорию
                        move_uploaded_file($filePath, ROOT . '/template/images/upload/' . $id . '.jpg');
                    }
                }

                header("Location: /admin/product");
            }


        }
        require_once (ROOT . '/views/admin_product/create.php');
        return true;
    }

    /**
     * @param $id
     * @return bool
     */
    public function actionUpdate($id)
    {
        // Получает список ВСЕХ категорий
        $categoriesList = Category::getCategoriesListAdmin();
        // Получает товар по id
        $product = Product::getProductById($id);

        if (isset($_POST['submit'])) {
            $options['name'] = $_POST['name'];
            $options['code'] = $_POST['code'];
            $options['price'] = $_POST['price'];
            $options['category_id'] = $_POST['category_id'];
            $options['brand'] = $_POST['brand'];
            $options['availability'] = $_POST['availability'];
            $options['description'] = $_POST['description'];
            $options['is_new'] = $_POST['is_new'];
            $options['is_recommended'] = $_POST['is_recommended'];
            $options['status'] = $_POST['status'];

            // Если данные по товару обновлены - проверяет загрузку изображения
            if (Product::updateProductById($id, $options)) {
                if (is_uploaded_file($_FILES['image']['tmp_name'])) {
                    $filePath = $_FILES['image']['tmp_name'];

                    // Перемещает загруженные файлы в корневую директорию.
                    move_uploaded_file($filePath, ROOT . '/images/upload/' . $id . '.jpg');
                }
            }

            header("Location: /admin/product");
        }
        require_once (ROOT . '/views/admin_product/update.php');
        return true;


    }
}