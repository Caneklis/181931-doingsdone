<div class="content">
    <section class="content__side">
        <?php if (isset($_SESSION['user'])): ?>
        <h2 class="content__side-heading">Проекты</h2>
        <nav class="main-navigation">
            <ul class="main-navigation__list">
                <?php foreach ($projects as $project): ?>
                <li class="main-navigation__list-item <?php if (isset($_GET['project']) && ($_GET['project'] === $project['id'])) {print 'main-navigation__list-item--active';} ?>">
                    <a class="main-navigation__list-item-link" href="/index.php?project_id=<?= $project['id'] ?>">
                        <?= $project['title']; ?></a>
                    <span class="main-navigation__list-item-count">
                        <?= $project['tasks']; ?></span>
                </li>
                <?php endforeach; ?>
            </ul>
        </nav>
        <a class="button button--transparent button--plus content__side-button" href="add-project.php" target="project_add">Добавить проект</a>
        <?php else: ?>
        <p class="content__side-info">Если у вас уже есть аккаунт, авторизуйтесь на сайте</p>
        <a class="button button--transparent content__side-button" href="auth.php">Войти</a>
        <?php endif; ?>
    </section>

    <main class="content__main">
        <h2 class="content__main-heading">Добавление задачи</h2>
        <? if (isset($errors['sql'])) {print ($errors['sql']);}?>
        <form class="form" action="" method="post">
            <div class="form__row">
                <label class="form__label" for="name">Название <sup>*</sup></label>
                <?php $classname = isset($errors['name']) ? "form__input--error" : "";
              $value = isset($form['name']) ? $form['name'] : ""; ?>
                <input class="form__input <?=$classname;?>" type="text" name="name" id="project_name" value="<?=$value;?>" placeholder="Введите название проекта">
                <?php if (isset($errors['name'])) {print ('<p class="form_message"><span class="form__message error-message">'.$errors['name'].'</span></p>');}?>
            </div>

            <div class="form__row form__row--controls">
                <?php if (!empty($errors)) {print ('<p class="error-message">Пожалуйста, исправьте ошибки в форме</p>');}?>
                <input class="button" type="submit" name="" value="Добавить">
            </div>
        </form>
    </main>
</div>