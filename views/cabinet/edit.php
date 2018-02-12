<?php include ROOT . '/views/layouts/header.php'; ?>

    <section>
        <div class="container">
            <div class="row">

                <div class="col-sm-4 col-sm-offset-4 padding-right">
                    <?php if ($result):?>
                        <p>Данные отредактированы</p>
                    <?php else:?>
                        <?php if (!empty($errors)):?>
                            <ul>
                                <?php foreach ($errors as $error):?>
                                    <li> - <?= $error ?></li>
                                <?php endforeach;?>
                            </ul>
                        <?php endif;?>
                        <div class="signup-form"><!--sign up form-->
                            <h2>Редактирование данных</h2>
                            <form action="#" method="post">
                                <input type="text" name="name" placeholder="Имя" value=""/>
                                <input type="password" name="password" placeholder="Пароль" value=""/>
                                <input type="submit" name="submit" class="btn btn-default" value="Редактировать" />
                            </form>
                        </div><!--/sign up form-->
                    <?php endif;?>
                    <br/>
                    <br/>
                </div>
            </div>
        </div>
    </section>

<?php include ROOT . '/views/layouts/footer_fix.php'; ?>