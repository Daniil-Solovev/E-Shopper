<?php include ROOT . '/views/layouts/header.php'; ?>

<section>
    <div class="container">
        <div class="row">
            <h1>Кабинет пользователя</h1>
            <ul>
                <li><a href="/cabinet/edit/">Редактировать данные</a></li>
                <li><a href="/cart/">Корзина</a></li>
                <?php if ($_SESSION['role'] == 'admin'):?>
                    <li><a href="/admin">Админ - панель</a></li>
                <?php endif;?>
            </ul>

        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer_fix.php'; ?>