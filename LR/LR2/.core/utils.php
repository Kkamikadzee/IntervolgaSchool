<?php
	function nullOrEmpty($val) : bool
	{
		if(is_string($val))
			return $val == NULL;

		return $val === NULL;
	}
?>