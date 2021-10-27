<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR2/.core/database/index.php');

    if(isset($_GET['clear']))
    {
        header("Location: index.php");
    }
    
    $title = 'Plant store';
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
                    value="<?php if(isset($_GET['priceMinFilter'])){ echo $_GET['priceMinFilter']; } ?>">
            </div>
            <div class="my-3">
                <input class="form-control" type="number" placeholder="Цена до" aria-label="default input example" name="priceMaxFilter"
                    value="<?php if(isset($_GET['priceMaxFilter'])){ echo $_GET['priceMaxFilter']; } ?>">
            </div>              
            <h5>Фильтрация по типу поля</h5>
            <div class="my-3">
                <select class="form-select form-select" aria-label=".form-select-sm example" name="fieldFilter"
                    value="<?php if(isset($_GET['fieldFilter'])){ echo $_GET['fieldFilter']; } ?>">
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
                name="descriptionFilter"><?php if(isset($_GET['descriptionFilter'])){ echo $_GET['descriptionFilter']; }?></textarea>
            </div>
            <h5>Фильтрация по наименованию</h5>
            <div class="my-3">   
                <input class="form-control" type="text" placeholder="Введите наименование товара" aria-label="default input example" name="nameFilter"
                    value="<?php if(isset($_GET['nameFilter'])){ echo $_GET['nameFilter']; } ?>">
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