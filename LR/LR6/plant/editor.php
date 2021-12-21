<?php 
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR6/.core/logic/index.php');

    $plantsLogic = new PlantsLogic();
	$fieldsLogic = new FieldsLogic();

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
					action="/LR6/plant/edit.php" 
					enctype="multipart/form-data">
				<div class="input-group">
					<input type="text" 
						class="form-control" 
						placeholder="Название" 
						name="plantName" 
						maxlength="60" 
						value="<?= $plant->getName(); ?>" 
						title="Название">
				</div>
				<div class="input-group">
					<select class="form-select" aria-label="Поле" 
						name="plantField" title="Поле">
						<?php foreach($fieldsLogic->getAll() as &$field): ?>
							<?php if ($field->getId() == $plant->getField()->getId()): ?>
								<option value="<?= $field->getId(); ?>" selected=""><?= $field->getName(); ?></option>
							<?php else: ?>
								<option value="<?= $field->getId(); ?>"><?= $field->getName(); ?></option>
							<?php endif; ?>
						<?php endforeach;?>
					</select>
				</div>
				<div class="input-group">
					<textarea class="form-control" 
						rows="3" 
						placeholder="Введите описание товара" 
						name="plantDescription"><?= $plant->getDescription(); ?></textarea>
				</div>
				<div class="input-group">
					<input type="number" 
						class="form-control" 
						placeholder="Стоимость" 
						name="plantPrice" 
						maxlength="60" 
						value="<?= $plant->getPrice(); ?>" 
						title="Стоимость"
						min="0"
						max="100000000"
						step="0.01">
				</div>
				<div class="input-group">
					<input type="hidden" name="MAX_FILE_SIZE" value="300000">
					<input type="file" class="form-control" placeholder="Фото" name="plantImage" value="<?= $plant->getImgPath(); ?>" title="Фото">
				</div>
				<div>
					<input type="hidden" name="plantId" value="<?= $plant->getId(); ?>">
					<button class="btn btn-primary" type="submit">Отправить</button>
				</div>
			</form>
		</div>
    </div>
</main>
<?php include('../footer.php');?>