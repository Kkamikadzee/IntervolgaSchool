<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR3/.core/logic/UsersLogic.php');
    
    $userName = null;
    $userLogic = new UsersLogic();
    if($userLogic->isAuthorized())
    {
        $userName = $userLogic->current()['email'];
    }
?>
<header>
    <div class="top-menu">
        <div class="container">
            <ul class="nav justify-content-between">
                <li class="nav-item">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link1" href="#">О нас</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link1" href="#">Контакты</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link1" href="#">Оплата и доставка</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link1" href="#">Гарантия на растения</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link1" href="#">Отзывы</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link1" href="#">Получить скидку</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link1" href="secret.php">Сверхсекретная ссылка</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <div class="d-flex">
                        <button type="button" class="btn btn-outline-light">СПЕЦАКЦИЯ</button>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="search-menu container">
        <ul class="nav justify-content-between">
            <li class="nav-item">
                <a class="logo" href="index.php">
                    <span class="logo-img"></span>
                    <span class="logo-text">ВЕСНА<br>ОСЕНЬ</span>
                </a>
            </li>
            <li class="nav-item">
                <div class="search-align">
                    <form class="row g-2">
                        <div class="col-auto">
                            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Поиск...</button>
                        </div>
                    </form>
                </div>
            </li>
            <li class="nav-item">
                <ul class="nav justify-content-between">
                    <li class="d-flex nav-item">
                        <p class="nav-link1 text-break mb-0">
                            <?php
                                if(!isset($userName) || is_null($userName))
                                {
                                    echo 'Вы не авторизованы. <a href="login.php"><u>Ввести логин и пароль</u></a> или <a href="signup.php"><u>зарегистрироваться</u></a>';
                                }
                                else
                                {
                                    echo 'Вы авторизованы как ' . $userName . '. <a href="logout.php"><u>Выйти</u></a>';
                                }
                            ?>
                        </p>
                    </li>
                    <li class="d-flex nav-item">
                        <a class="nav-link" href="#">Корзина</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <ul class="nav justify-content-center">
        <li class="nav-item">
            <a class="jlink" href="https://vesna-osen.ru/catalog/ctg/vinograd/">
                саженцы винограда
            </a>
            <a class="jlink" href="https://vesna-osen.ru/catalog/ctg/vishnya/">
                саженец вишни
            </a>
        </li>
    </ul>
</header>