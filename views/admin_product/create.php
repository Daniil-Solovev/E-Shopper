<?php include ROOT . '/views/layouts/header_admin.php'  ?>

<section>
    <div class="container">
        <div class="row">

            <br/>

            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="/admin">Админпанель</a></li>
                    <li><a href="/admin/product">Управление товарами</a></li>
                    <li class="active">Редактировать товар</li>
                </ol>
            </div>


            <h4>Добавить новый товар</h4>

            <br/>

            <?php if (isset($errors) && is_array($errors)): ?>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li> - <?= $error  ?></li>
                    <?php endforeach  ?>
                </ul>
            <?php endif  ?>

            <div class="col-lg-4">
                <div class="login-form">
                    <form action="#" method="post" enctype="multipart/form-data">

                        <p>Название товара</p>
                        <input type="text" name="name" placeholder="" value="" required>

                        <p>Артикул</p>
                        <input type="text" name="code" placeholder="" value="" required>

                        <p>Стоимость, $</p>
                        <input type="text" name="price" placeholder="" value="" required>

                        <p>Категория</p>
                        <select name="category_id">
                            <?php if (is_array($categoriesList)): ?>
                                <?php foreach ($categoriesList as $category): ?>
                                    <option value="<?= $category['id']  ?>">
                                        <?= $category['name']  ?>
                                    </option>
                                <?php endforeach  ?>
                            <?php endif  ?>
                        </select>

                        <br/><br/>

                        <p>Производитель</p>
                        <input type="text" name="brand" placeholder="" value="" required>

                        <p>Изображение товара</p>
                        <input type="file" name="image" placeholder="" value="" required>

                        <p>Детальное описание</p>
                        <textarea name="description" required></textarea>

                        <br/><br/>

                        <p>Наличие на складе</p>
                        <select name="availability" required>
                            <option value="1" selected="selected">Да</option>
                            <option value="0">Нет</option>
                        </select>

                        <br/><br/>

                        <p>Новинка</p>
                        <select name="is_new" required>
                            <option value="1" selected="selected">Да</option>
                            <option value="0">Нет</option>
                        </select>

                        <br/><br/>

                        <p>Рекомендуемые</p>
                        <select name="is_recommended" required>
                            <option value="1" selected="selected">Да</option>
                            <option value="0">Нет</option>
                        </select>

                        <br/><br/>

                        <p>Статус</p>
                        <select name="status" required>
                            <option value="1" selected="selected">Отображается</option>
                            <option value="0">Скрыт</option>
                        </select>

                        <br/><br/>

                        <input type="submit" name="submit" class="btn btn-default" value="Сохранить" required>

                        <br/><br/>

                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer_admin.php'  ?>
