<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>
        <?php 
            echo $title;
        ?>
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
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
                    <a class="logo" href="/">
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
                            <a class="nav-link" href="#">Войти</a>
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