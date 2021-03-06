<div class="content">
    <section class="content__side">
        <?php if (isset($_SESSION['user'])): ?>
        <h2 class="content__side-heading">Проекты</h2>
        <nav class="main-navigation">
            <ul class="main-navigation__list">
                <?php foreach ($projects as $project): ?>
                <li class="main-navigation__list-item <?php if (isset($_GET['project']) && ($_GET['project'] === $project['id'])) {print (' main-navigation__list-item--active');} ?>">
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
        <h2 class="content__main-heading">Список задач</h2>

        <form class="search-form" action="index.php" method="post">
            <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">

            <input class="search-form__submit" type="submit" name="" value="Искать">
        </form>

        <div class="tasks-controls">
            <nav class="tasks-switch">
                <a href="/" class="tasks-switch__item tasks-switch__item--active">Все задачи</a>
                <a href="/" class="tasks-switch__item">Повестка дня</a>
                <a href="/" class="tasks-switch__item">Завтра</a>
                <a href="/" class="tasks-switch__item">Просроченные</a>
            </nav>

            <label class="checkbox">
                <!--добавить сюда аттрибут "checked", если переменная $show_complete_tasks равна единице-->
                <input class="checkbox__input visually-hidden show_completed" <?php if ($show_complete_tasks==1): ?>checked
                <?php endif; ?>
                type="checkbox">
                <span class="checkbox__text">Показывать выполненные</span>
            </label>
        </div>

        <table class="tasks">
            <?php if(isset($tasks) && !empty($tasks)) foreach ($tasks as $task): ?>
            <?php if ( $show_complete_tasks == 1 || !$task['task_status'] ): ?>
            <tr class="tasks__item task  <?php if ($task['task_status']): ?> task--completed <?php endif; ?>   <?php if (importantTaskCheck($task['deadline'])): ?> task--important <?php endif; ?>">
                <td class="task__select">
                    <label class="checkbox task__checkbox">
                        <input class="checkbox__input visually-hidden task__checkbox" type="checkbox" value="1" <?php if ($task['task_status']): ?> checked
                        <?php endif; ?>>
                        <span class="checkbox__text">
                            <?=$task['title'];?></span>
                    </label>
                </td>

                <td class="task__file">
                    <?php if ($task['file']): ?> <a class="download-link" href="/uploads/<?=$task['file'];?>"></a>
                    <?php endif; ?>
                </td>

                <td class="task__date">
                    <?=$task['deadline'];?>
                </td>
            </tr>
            <?php endif; ?>
            <?php endforeach; ?>
        </table>
    </main>

</div>