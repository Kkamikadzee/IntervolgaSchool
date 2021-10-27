<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR2/.core/database/index.php');

    if(isset($_GET['clear']))
    {
        header("Location: index.php");
    }
    
    $title = 'Plant store';
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
            <form method='get'>
                <div class="my-3">
                    <h5>Фильтрация результата поиска</h5>
                </div>
                <h5>По цене</h5>
                <div class="my-3">            
                    <input class="form-control" type="number" placeholder="Цена от" aria-label="default input example" name="priceMinFilter"
                        value="<?php if(isset($_GET['priceMinFilter'])){ echo htmlspecialchars($_GET['priceMinFilter']); } ?>">
                </div>
                <div class="my-3">
                    <input class="form-control" type="number" placeholder="Цена до" aria-label="default input example" name="priceMaxFilter"
                        value="<?php if(isset($_GET['priceMaxFilter'])){ echo htmlspecialchars($_GET['priceMaxFilter']); } ?>">
                </div>              
                <h5>Фильтрация по типу поля</h5>
                <div class="my-3">
                    <select class="form-select form-select" aria-label=".form-select-sm example" name="fieldFilter"
                        value="<?php if(isset($_GET['fieldFilter'])){ echo htmlspecialchars($_GET['fieldFilter']); } ?>">
                        <option selected></option>
                        <?php
                            $fields = (new FieldsTable())->getFields();
                            if($fields !== null)
                            {
                                foreach($fields as &$field)
                                {
                                    echo '<option value="' . $field['id'] . '">' . $field['name'] . '</option>';
                                }
                            }
                        ?>
                    </select>
                </div>
                <h5>Фильтрация по описанию</h5>
                <div class="my-3">            
                    <textarea class="form-control" rows="3" placeholder="Введите описание товара" 
                    name="descriptionFilter"><?php if(isset($_GET['descriptionFilter'])){ echo htmlspecialchars($_GET['descriptionFilter']); }?></textarea>
                </div>
                <h5>Фильтрация по наименованию</h5>
                <div class="my-3">   
                    <input class="form-control" type="text" placeholder="Введите наименование товара" aria-label="default input example" name="nameFilter"
                        value="<?php if(isset($_GET['nameFilter'])){ echo htmlspecialchars($_GET['nameFilter']); } ?>">
                </div>
                <div class="my-3 d-grid gap-2 col-6 mx-auto">
                    <button class="btn btn-primary btn-warning rounded-pill add" type="submit">Применить фильтр</button>
                    <button class="btn btn-primary btn-light rounded-pill add" type="submit" name="clear">Очистить фильтр</button>
                </div>
            </form>

            <table class="table align-middle text-center">
              <thead>
                <tr>
                  <th class="col-md-2" scope="col">Изображение</th>
                  <th class="col-md-2" scope="col">Название</th>
                  <th class="col-md-2" scope="col">Типо поля</th>
                  <th class="col-md-6" scope="col">Описание</th>
                  <th class="col-md-1" scope="col">Стоимость</th>
                </tr>
              </thead>
              <tbody>
                <?php
                    $data = (new CatalogFromDatabase())->getCatalog(
                        $nameFilter = (isset($_GET['nameFilter'])) ? $_GET['nameFilter'] : null, 
                        $fieldFilter = (isset($_GET['fieldFilter'])) ? $_GET['fieldFilter'] : null, 
                        $descriptionFilter = (isset($_GET['descriptionFilter'])) ? $_GET['descriptionFilter'] : null, 
                        $priceMinFilter = (isset($_GET['priceMinFilter'])) ? $_GET['priceMinFilter'] : null, 
                        $priceMaxFilter = (isset($_GET['priceMaxFilter'])) ? $_GET['priceMaxFilter'] : null);

                    $formatRow = '
                    <tr>
                      <th scope="row"><img width="200" height="200" src="inc/catalog_images/%s"></th>
                      <td>%s</td>
                      <td>%s</td>
                      <td>%s</td>
                      <td>%s</td>
                    </tr>
                    ';

                    foreach($data as &$row)
                    {
                        echo sprintf($formatRow, $row['img_path'], $row['name'], $row['field_name'], $row['description'], $row['price']);
                    }
                ?>
            
              </tbody>
            </table>
        </div>
    </main>
<?php include('footer.php');?>
</body>
</html>
