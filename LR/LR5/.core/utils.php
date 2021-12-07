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
?>