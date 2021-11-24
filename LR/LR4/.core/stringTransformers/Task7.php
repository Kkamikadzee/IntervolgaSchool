<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . '/LR4/.core/stringTransformers/IStringTransformer.php');	

	class Task7 implements IStringTransformer
	{
 		private $replacePairs = [
			'/!{2,}/' => '!!!',
			'/\.{3,}/' => '…'
		];

		public function __construct()
		{

		}

		public function replace($inputText)
		{
			foreach ($this->replacePairs as $regex => $replacement)
			{
				$inputText = preg_replace($regex, $replacement, $inputText);
			}

			return $inputText;
		}		
	}
?>