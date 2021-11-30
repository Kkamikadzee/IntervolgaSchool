<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR4/.core/stringTransformers/index.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR4/.core/tableOfContents/index.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR4/.core/lab4Presets.php');
    
    $title = 'Plant store';

    $stringTransformers = getStringTransformers();

    $replacedText = null;
    $tableOfContents = null;
    if(isset($_POST['inputText']))
    {
        $replacedText = $_POST['inputText'];

        $tableOfContents = (new TableOfContentsCreator())->create($replacedText);
        if($tableOfContents)
        {
            $replacedText = $tableOfContents->getTextWithLinks();
        }

        foreach ($stringTransformers as &$stringTransformer)
        {
            $replacedText = $stringTransformer->replace($replacedText);
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
        <form method="post">
            <div class="my-3 d-grid gap-2 col-6 mx-auto">
                <?php 
                    if(isset($_POST['inputText']) && $tableOfContents) 
                    {
                        echo($tableOfContents->getTableOfContentsView());
                    }
                ?>
            </div>
            <div class="my-3 d-grid gap-2 col-6 mx-auto">            
                <textarea class="form-control" placeholder="Введите текст" 
                    name="inputText"><?php 
                        if(isset($_POST['inputText'])){ 
                            echo htmlspecialchars($_POST['inputText']); 
                        }
                        elseif(isset($_GET['preset']))
                        {
                            echo htmlspecialchars(getPresets()[$_GET['preset']]); 
                        }
                    ?></textarea>
                <button type="submit" class="btn btn-primary btn-warning" name="reg">Отправить</button>            
            </div>
            <div class="my-3 d-grid gap-2 col-6 mx-auto">
                <?php if(isset($_POST['inputText'])) {echo($replacedText);} ?>
            </div>
        </form>
    </main>
<?php include('footer.php');?>
</body>
</html>
