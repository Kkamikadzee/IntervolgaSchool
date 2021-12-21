<?php 
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR6/.core/logic/PlantsLogic.php');

    $plantsLogic = new PlantsLogic();
    $maxLenDescription = 64;

    include('../header.php');
?>
<main>
    <div class="my-3 d-grid gap-2 col-8 mx-auto">
        <h3>Растения</h3>
        <div>
        	<div>
				<a href="/LR6/plant/adder.php" class="btn btn-primary" role="button">Добавить</a>
			</div>
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th class="col-md-1" scope="col">Id</th>
                        <th class="col-md-2" scope="col">Название</th>
                        <th class="col-md-1" scope="col">Поле</th>
                        <th class="col-md-3" scope="col">Описание</th>
                        <th class="col-md-1" scope="col">Стоимость</th>
                        <th class="col-md-3" scope="col">Фото</th>
                        <th class="col-md-4" scope="col" colspan="2">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($plantsLogic->getAll() as &$plant): ?>
                    <tr>
                        <th scope="row"><?= $plant->getId(); ?></th>
                        <td><?= $plant->getName(); ?></td>
                        <td><?= $plant->getField()->getName(); ?></td>
                        <td><?= mb_strlen($plant->getDescription()) < $maxLenDescription ? $plant->getDescription() : mb_substr($plant->getDescription(), 0, $maxLenDescription) . '…'; ?></td>
                        <td><?= $plant->getPrice(); ?></td>
                        <td><img width="200" height="200" src="/LR6/get_image.php?img=<?= $plant->getImgPath(); ?>"></td>
                        <td>
                            <a class="btn btn-primary" type="button" id="edit" href="/LR6/plant/editor.php?<?=http_build_query(['id' => $plant->getId()]);?>">Редактировать</a>
                        </td>
                        <td>
                            <a class="btn btn-danger delete" id="delete" href="/LR6/plant/deleter.php?<?=http_build_query(['id' => $plant->getId()]);?>" >Удалить</a>
                        </td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</main>
<?php include('../footer.php');?>