<?php include ROOT . '/views/layouts/header_admin.php' ?>

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


            <h4>Редактировать товар #<?=$id?></h4>

            <br/>

            <div class="col-lg-4">
                <div class="login-form">
                    <form action="#" method="post" enctype="multipart/form-data">

                        <p>Название товара</p>
                        <input type="text" name="name" placeholder="" value="<?= $product['0']['name'] ?>">

                        <p>Артикул</p>
                        <input type="text" name="code" placeholder="" value="<?= $product['0']['code'] ?>">

                        <p>Стоимость, $</p>
                        <input type="text" name="price" placeholder="" value="<?= $product['0']['price'] ?>">

                        <p>Категория</p>
                        <select name="category_id">
                            <?php if (is_array($categoriesList)): ?>
                                <?php foreach ($categoriesList as $category): ?>
                                    <option value="<?= $category['id'] ?>"
                                        <?= $product['0']['category_id'] == $category['id'] ? ' selected="selected"' : ''  ?>>
                                        <?= $category['name'] ?>
                                    </option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>

                        <br/><br/>

                        <p>Производитель</p>
                        <input type="text" name="brand" placeholder="" value="<?= $product['0']['brand'] ?>">

                        <p>Изображение товара</p>
                        <img src="<?= Product::getImage($product['0']['id']) ?>" width="200" alt="" />
                        <input type="file" name="image" placeholder="" value="<?= $product['0']['image'] ?>">

                        <p>Детальное описание</p>
                        <textarea cols="10" rows="10" name="description"><?= $product['0']['description'] ?></textarea>

                        <br/><br/>

                        <p>Наличие на складе</p>
                        <select name="availability">
                            <option value="1" <?= $product['0']['availability'] == 1 ? ' selected="selected"' : ''  ?>>Да</option>
                            <option value="0" <?= $product['0']['availability'] == 0 ? ' selected="selected"' : ''  ?>>Нет</option>
                        </select>

                        <br/><br/>
                        <p>Новинка</p>
                        <select name="is_new">
                            <option value="1" <?= $product['0']['is_new'] == 1 ? ' selected="selected"' : ''  ?>>Да</option>
                            <option value="0" <?= $product['0']['is_new'] == 0 ? ' selected="selected"' : ''  ?>>Нет</option>
                        </select>

                        <br/><br/>

                        <p>Рекомендуемые</p>
                        <select name="is_recommended">
                            <option value="1" <?= $product['0']['is_recommended'] == 1 ? ' selected="selected"' : ''  ?>>Да</option>
                            <option value="0" <?= $product['0']['is_recommended'] == 0 ? ' selected="selected"' : ''  ?>>Нет</option>
                        </select>

                        <br/><br/>

                        <p>Статус</p>
                        <select name="status">
                            <option value="1" <?= $product['0']['status'] == 1 ? ' selected="selected"' : ''  ?>>Отображается</option>
                            <option value="0" <?= $product['0']['status'] == 1 ? ' selected="selected"' : ''  ?>>Скрыт</option>
                        </select>

                        <br/><br/>

                        <input type="submit" name="submit" class="btn btn-default" value="Сохранить">

                        <br/><br/>

                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer_admin.php' ?>
