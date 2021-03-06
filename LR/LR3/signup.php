<?php
    $title = 'Plant store';
    $emailRegExp = '^[^@\s]+@[^@\s]+\.[^@\s]+$';
    $dataRegExp = '^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$';
	$urlVkRegExp = '/https:\/\/vk\.com\/(\w|_)+/';

    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR3/.core/index.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR3/.core/utils.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR3/.core/logic/UsersLogic.php');

    if((new UsersLogic())->isAuthorized())
    {
        header("Location: index.php");
    }

    if(isset($_POST['reg']))
    {
        try
        {
            $userLogic = new UsersLogic();
            $userLogic->signUp($_POST['email'], $_POST['full_name'], $_POST['data_of_birth'], $_POST['gender'], 
                $_POST['blood_type'], $_POST['rh'], $_POST['password1'], $_POST['password2'], 
                $_POST['address_country'], $_POST['address_city'], $_POST['address_street'], 
                $_POST['address_house'], $_POST['address_room'],
                $_POST['interests'], $_POST['url_vk']);

            header("Location: index.php");
        }
        catch(Exception $e)
        {
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
                        <li class="breadcrumb-item"><a href="#">???????????????? ????????????????</a></li>
                        <li class="breadcrumb-item active">???????????????? ????????????????</li>
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
                <div class="my-3 w-50 mx-auto">
                    <label for="email" class="form-label">Email</label>
                    <input 
                        type="email" 
                        class="form-control" 
                        id="email"
                        name="email"
                        required="required"
                        title="???????????????? ???????????? ???????????????????????? ??????????"
                        pattern="<?php echo $emailRegExp; ?>" 
                        placeholder="example@example.com"
                        value="<?php if(isset($_POST['email'])){ echo htmlspecialchars($_POST['email']); } ?>"
                    />
                </div>
                <div class="my-3 w-50 mx-auto">
                    <label for="full_name" class="form-label">??????</label>
                    <input type="text" class="form-control" id="full_name" name="full_name" required="required" placeholder="???????????? ???????? ????????????????"
                        value="<?php if(isset($_POST['full_name'])){ echo htmlspecialchars($_POST['full_name']); } ?>">
                </div>
                <div class="my-3 w-50 mx-auto">
                  <label for="data_of_birth" class="form-label">???????? ????????????????</label>
                  <input 
                      type="text" 
                      class="form-control" 
                      id="data_of_birth"
                      name="data_of_birth"
                      required="required"
                      title="?????????????? ???????? ?? ?????????????? ????.????.????????"
                      pattern="<?php echo $dataRegExp; ?>" 
                      placeholder="01.01.2001"
                      value="<?php if(isset($_POST['data_of_birth'])){ echo htmlspecialchars($_POST['data_of_birth']); } ?>"
                  />
                </div>
                <div class="my-3 w-50 mx-auto">
                    <label for="gender" class="form-label">??????</label>
                    <select id="gender" name="gender" class="form-select" required="required" aria-label="Default select example">
                        <option <?php if(isset($_POST['gender'])){ if($_POST['gender'] == 1) {echo 'selected';} }?> value="1">??????.</option>
                        <option <?php if(isset($_POST['gender'])){ if($_POST['gender'] == 2) {echo 'selected';} }?> value="2">??????.</option>
                        <option <?php if(isset($_POST['gender'])){ if($_POST['gender'] == 3) {echo 'selected';} }?> value="3">????????????</option>
                    </select>
                </div>
                <div class="my-3 w-50 mx-auto">
                    <label class="form-label">??????????</label>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="address_country" class="form-label">????????????</label>
                            <input type="text" class="form-control" id="address_country" name="address_country" placeholder="????????????"
                                value="<?php if(isset($_POST['address_country'])){ echo htmlspecialchars($_POST['address_country']); } ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="address_city" class="form-label">??????????</label>
                            <input type="text" class="form-control" id="address_city" name="address_city" placeholder="????????????"
                                value="<?php if(isset($_POST['address_city'])){ echo htmlspecialchars($_POST['address_city']); } ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="address_street" class="form-label">??????????</label>
                            <input type="text" class="form-control" id="address_street" name="address_street" placeholder="????????????"
                                value="<?php if(isset($_POST['address_street'])){ echo htmlspecialchars($_POST['address_street']); } ?>">
                        </div>
                        <div class="col-md-2">
                            <label for="address_house" class="form-label">??????</label>
                            <input type="text" class="form-control" id="address_house" name="address_house" placeholder="0"
                                value="<?php if(isset($_POST['address_house'])){ echo htmlspecialchars($_POST['address_house']); } ?>">
                        </div>
                        <div class="col-md-2">
                            <label for="address_room" class="form-label">????????????????</label>
                            <input type="text" class="form-control" id="address_room" name="address_room" placeholder="0"
                                value="<?php if(isset($_POST['address_room'])){ echo htmlspecialchars($_POST['address_room']); } ?>">
                        </div>
                    </div>
                </div>
                <div class="my-3 w-50 mx-auto">
                  <label for="interests" class="form-label">??????????????</label>
                  <textarea class="form-control" rows="3" placeholder="??????????????????????,..." id="interests" name="interests"><?php if(isset($_POST['interests'])){ echo htmlspecialchars($_POST['interests']); } ?></textarea>
                </div>
                <div class="my-3 w-50 mx-auto">
                  <label for="url_vk" class="form-label">???????????? ???? ?????????????? ????</label>
                  <input 
                      type="text" 
                      class="form-control" 
                      id="url_vk" 
                      name="url_vk"
                      title="?????????????? ???????????? ?? ?????????????? https://vk.com/<ID>"
                      pattern="<?php echo $urlVkRegExp; ?>" 
                      placeholder="https://vk.com/idx"
                      value="<?php if(isset($_POST['url_vk'])){ echo htmlspecialchars($_POST['url_vk']); } ?>"
                  />
                </div>
                <div class="my-3 w-50 mx-auto">
                    <label for="blood_type" class="form-label">???????????? ??????????</label>
                    <select id="blood_type" name="blood_type" class="form-select" required="required" aria-label="Default select example">
                        <option <?php if(isset($_POST['gender'])){ if($_POST['gender'] == 1) {echo 'selected';} }?> value="1">0 (I)</option>
                        <option <?php if(isset($_POST['gender'])){ if($_POST['gender'] == 2) {echo 'selected';} }?> value="2">A (II)</option>
                        <option <?php if(isset($_POST['gender'])){ if($_POST['gender'] == 3) {echo 'selected';} }?> value="3">B (III)</option>
                        <option <?php if(isset($_POST['gender'])){ if($_POST['gender'] == 4) {echo 'selected';} }?> value="3">AB (IV)</option>
                    </select>
                </div>
                <div class="my-3 w-50 mx-auto">
                    <label for="rh" class="form-label">??????????-????????????</label>
                    <select id="rh" name="rh" class="form-select" required="required" aria-label="Default select example">
                        <option <?php if(isset($_POST['rh'])){ if($_POST['rh'] == 1) {echo 'selected';} }?> value="1">?????????????????????????? (+)</option>
                        <option <?php if(isset($_POST['rh'])){ if($_POST['rh'] == 2) {echo 'selected';} }?> value="2">?????????????????????????? (-)</option>                    
                    </select>
                </div>
                <div class="my-3 w-50 mx-auto">
                    <label for="password1" class="form-label">????????????</label>
                    <input type="password" class="form-control" id="password1" name="password1" required="required" placeholder="**********"
                        value="<?php if(isset($_POST['password1'])){ echo htmlspecialchars($_POST['password1']); } ?>">
                </div>
                <div class="my-3 w-50 mx-auto">
                    <label for="password2" class="form-label">?????????????????????? ????????????</label>
                    <input type="password" class="form-control" id="password2" name="password2" required="required" placeholder="**********"
                        value="<?php if(isset($_POST['password2'])){ echo htmlspecialchars($_POST['password2']); } ?>">
                </div>
                <div class="my-3 d-grid gap-2 col-5 mx-auto">
                    <button type="submit" class="btn btn-primary btn-warning" name="reg">????????????????????????????????????</button>
                </div>
            </form>
            <div class="my-3 d-grid gap-2 col-5 mx-auto">
                <div class="form-group">
                    <p class="text-center">?????? ???????? ??????????????? <a href="login.php">?????????? ?? ??????????????</a></p>
                </div>
            </div>
        </div>
    </main>
    <?php include('footer.php');?>
</body>
</html>
