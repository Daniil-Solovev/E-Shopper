<?php include ROOT . '/views/layouts/header.php'; ?>

    <section>
        <div class="container">
            <div class="row">

                <div class="col-sm-4 col-sm-offset-4 padding-right">
                <?php if ($result):?>
                    <p>Ваше сообщение отправлено. Мы свяжемся с Вами в ближайшее время</p>
                <?php else:?>
                    <?php if (!empty($errors)):?>
                        <ul>
                            <?php foreach ($errors as $error):?>
                                <li> - <?= $error ?></li>
                            <?php endforeach;?>
                        </ul>
                    <?php endif;?>
                    <div class="signup-form"><!--sign up form-->
                        <h2>Обратная связь</h2>
                        <form action="" method="post" enctype="multipart/form-data">
                            <textarea name="feedback" rows="10" cols="45" placeholder="Введите Ваше сообщение"></textarea>
                            <input type="file" name="file" value="Загрузить файл">
                            <input type="submit" name="submit" class="btn btn-default" value="Отправить" />
                        </form>
                    </div><!--/sign up form-->
                <?php endif;?>
                    <br/>
                    <br/>
                </div>
            </div>
        </div>
    </section>

<?php include ROOT . '/views/layouts/footer.php'; ?>