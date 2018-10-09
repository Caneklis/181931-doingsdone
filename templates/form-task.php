<div class="content">
    <section class="content__side">
        <h2 class="content__side-heading">Проекты</h2>

        <nav class="main-navigation">
            <ul class="main-navigation__list">
                <?php foreach ($projects as $project): ?>
                <li class="main-navigation__list-item">
                    <a class="main-navigation__list-item-link" href="/index.php?project_id=<?= $project['id'] ?>">
                        <?= $project['title']; ?></a>
                    <span class="main-navigation__list-item-count">
                            <?= $project['tasks']; ?>
                        </span>
                </li>
                <?php endforeach;?>
            </ul>
        </nav>

        <a class="button button--transparent button--plus content__side-button" href="form-project.html">Добавить проект</a>
    </section>

    <main class="content__main">
        <h2 class="content__main-heading">Добавление задачи</h2>

        <form class="form" action="add.php" method="post" enctype="multipart/form-data">
            <div class="form__row">
               <?php $classname = isset($errors['title']) ? "form__input--error" : "";
                     $value = isset($tasks['title']) ? $tasks['title'] : ""; ?>
               
                <label class="form__label" for="name">Название <sup>*</sup></label>

                <input class="form__input <?=$classname;?>" type="text" name="name" id="name" value="<?=$value;?>" placeholder="Введите название">
            </div>

            <div class="form__row">
                <label class="form__label" for="project">Проект <sup>*</sup></label>
               <?php $classname = isset($errors['project_id']) ? "form__input--error" : "";
                     $value = isset($tasks['project_id']) ? $tasks['project_id'] : ""; ?>
                
                <select class="form__input form__input--select" name="project" id="project">
                <?php foreach ($projects as $project): ?>
                    <option value="<?= $project['title']; ?>"><?= $project['title']; ?></option>
                <?php endforeach;?>
                </select>

            </div>

            <div class="form__row">
                <label class="form__label" for="date">Дата выполнения</label>
                <?php $classname = isset($errors['deadline']) ? "form__input--error" : "";
                      $value = isset($tasks['deadline']) ? $tasks['deadline'] : ""; ?>

                <input class="form__input form__input--date  <?=$classname;?>" type="date" name="date" id="date" value="<?=$value;?>" placeholder="Введите дату в формате ДД.ММ.ГГГГ">
            </div>

            <div class="form__row">
                <label class="form__label" for="preview">Файл</label>

                <div class="form__input-file">
                    <input class="visually-hidden" type="file" name="preview" id="preview" value="">

                    <label class="button button--transparent" for="preview">
                        <span>Выберите файл</span>
                    </label>
                </div>
            </div>

            <div class="form__row form__row--controls">
                <input class="button" type="submit" name="" value="Добавить">
            </div>
        </form>
    </main>
</div>