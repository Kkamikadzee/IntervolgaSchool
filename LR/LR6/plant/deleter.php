<?php 
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR6/.core/logic/index.php');

    $plantsLogic = new PlantsLogic();

	$plant = null;
	if(isset($_GET['id']))
	{
		$plant = $plantsLogic->getById($_GET['id']);
	}
	else
	{
		header("Location: ".$_SERVER['HTTP_REFERER'], true, 303);
	}

    include('../header.php');
?>
<main>
    <div class="my-3 d-grid gap-2 col-8 mx-auto">
        <h3>Растения</h3>
        <div>
			<form class="row row-cols-lg-auto g-3 align-items-center" 
					name="editPlant" 
					method="post" 
					action="/LR6/plant/delete.php" 
					enctype="multipart/form-data">
				<div class="input-group">
					<input type="text" 
						class="form-control" 
						placeholder="Название" 
						name="plantName" 
						maxlength="60" 
						value="<?= $plant->getName(); ?>" 
						title="Название"
						readonly="readonly">
				</div>
				<div class="input-group">
					<input type="hidden" name="plantField" value="<?= $plant->getField()->getId(); ?>">
					<input type="text" 
						class="form-control" 
						placeholder="Поле" 
						name="plantFieldName" 
						maxlength="60" 
						value="<?= $plant->getField()->getName(); ?>" 
						title="Поле"
						readonly="readonly">
				</div>
				<div class="input-group">
					<textarea class="form-control" 
						rows="3" 
						placeholder="Введите описание товара" 
						name="plantDescription"
						readonly="readonly"><?= $plant->getDescription(); ?></textarea>
				</div>
				<div class="input-group">
					<input type="number" 
						class="form-control" 
						placeholder="Стоимость" 
						name="plantPrice" 
						maxlength="60" 
						value="<?= $plant->getPrice(); ?>" 
						title="Стоимость" 
						readonly="readonly">
				</div>
				<div class="input-group">
					<img width="200" height="200" src="/LR6/get_image.php?img=<?= $plant->getImgPath(); ?>">				
				</div>
				<div>
					<input type="hidden" name="plantId" value="<?= $plant->getId(); ?>">
					<input type="hidden" name="plantImgPath" value="<?= $plant->getImgPath(); ?>">
					<div>
						<button class="btn btn-danger delete" type="submit">Удалить</button>
						<a href="/LR6/plant/index.php" class="btn btn-primary" role="button">Отмена</a>
					</div>
				</div>
			</form>
		</div>
    </div>
</main>
<?php include('../footer.php');?>