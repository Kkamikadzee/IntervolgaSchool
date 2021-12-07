<?php
    $title = 'Plant store';
    $emailRegExp = '^[^@\s]+@[^@\s]+\.[^@\s]+$';

    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR3/.core/logic/UsersLogic.php');

    if((new UsersLogic())->isAuthorized())
    {
        header("Location: index.php");
    }

    if(isset($_POST['login']))
    {
        try
        {
            if(isset($_COOKIE["AuthorizationAttempts"]) && $_COOKIE["AuthorizationAttempts"] >= 3)
                throw new Exception("Попытки авторизации исчерпаны, возвращайтесь через час.");

            $userLogic = new UsersLogic();
            $userLogic->signIn($_POST['email'], $_POST['password']);

            if(isset($_COOKIE["AuthorizationAttempts"]))
                setcookie("AuthorizationAttempts", null, time() - 3600);

            header("Location: index.php");
        }
        catch(Exception $e)
        {
            if(!isset($_COOKIE["AuthorizationAttempts"]))
            {
                setcookie("AuthorizationAttempts", 1, time() + 3600);
            }
            else
            {
                setcookie("AuthorizationAttempts", $_COOKIE["AuthorizationAttempts"] + 1, time() + 3600);
            }
            $_POST['error'] = $e->getMessage();
        }
    }

?>
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
    <?php
        include('header.php');
    ?>
    <main>
        <div class="container">
            <div class="my-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Домашняя страница</a></li>
                        <li class="breadcrumb-item active">Вход в аккаунт</li>
                    </ol>
                </nav>
            </div>
            <?php
                if(isset($_POST['error']))
                {
                    echo '<div class="my-3 d-grid gap-2 col-5 mx-auto alert alert-danger" role="alert">';
                    echo $_POST['error'];
                    echo '</div>';
                }
            ?>
            <form method='post'>
                <div class="my-3 w-25 mx-auto">
                    <label for="email" class="form-label">Email</label>
                    <input 
                        type="email" 
                        class="form-control" 
                        id="email"
                        name="email"
                        required="required"
                        title="Неверный формат элекстронной почты"
                        pattern="<?php echo $emailRegExp; ?>" 
                        placeholder="example@example.com"
                        value="<?php if(isset($_POST['email'])){ echo htmlspecialchars($_POST['email']); } ?>"
                    />
                </div>
                <div class="my-3 w-25 mx-auto">
                    <label for="password" class="col-sm-2 col-form-label">Пароль</label>
                    <input type="password" class="form-control" id="password" name="password" required="required" placeholder="**********"
                        value="<?php if(isset($_POST['password'])){ echo htmlspecialchars($_POST['password']); } ?>">
                </div>
                <div class="my-3 d-grid gap-2 col-3 mx-auto">
                    <button type="submit" class="btn btn-primary btn-warning" name="login">Войти</button>
                </div>
            </form>
            <div class="form-group">
                <p class="text-center">Ещё нет аккаунта? <a href="signup.php">Зарегистрируйтесь</a></p>
            </div>
        </div>
    </main>
    <?php include('footer.php');?>
</body>
</html>
