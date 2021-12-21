<?php
	function nullOrEmpty($val) : bool
	{
		if(is_string($val))
			return $val == NULL;

		return $val === NULL;
	}

	function getMd5Hash($str)
	{
		$hashSalt = "Кто такой Гусейн Гасанов?";
		return md5(md5($str) . $hashSalt, $raw_output = true);
	}

	function getPdoParamType($value)
	{
		if(is_int($value))
			return PDO::PARAM_INT;
		elseif(is_bool($value))
			return PDO::PARAM_BOOL;
		elseif(is_null($value))
			return PDO::PARAM_NULL;
		elseif(is_string($value))
			return PDO::PARAM_STR;
		else
			return FALSE;
	}

	function getPathToCatalogImage($fileName)
	{
		return 'inc/catalog_images/' . $fileName;
	}

	function uploadFile($file, $maxFileSize)
    {
        if(nullOrEmpty($file['size']) || $file['size'] == 0)
        {
            return null;
        }

        $imgName = htmlspecialchars($file['name']);

        if (!$file['error'] == UPLOAD_ERR_OK)
        {
            throw new Exception('Ошибка при загрузке файла' . '[' . $file['error'] . ']');
        }
        if ($file['size'] > $_POST['MAX_FILE_SIZE'])
        {
            throw new Exception('Слишком большой файл');
        }
        if (!move_uploaded_file($file['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/LR6/' . getPathToCatalogImage($imgName))) 
        {
            throw new Exception('Ошибка при загрузке файла');
        }

        return $imgName;
    }
?>