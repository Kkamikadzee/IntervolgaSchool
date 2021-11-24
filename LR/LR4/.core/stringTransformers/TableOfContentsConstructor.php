<?php
	// use Tree\Node\Node; //https://github.com/nicmart/Tree/tree/0.3.1

	class TableOfContentsConstructor
	{
 		private $headersRegex = '/(<h1>[\s\S]*?<\/h1>)|(<h2>[\s\S]*?<\/h2>)|(<h3>[\s\S]*?<\/h3>)/u';

		public function __construct()
		{

		}

		private function getHeaderLevel($str)
		{
			return intval(mb_str_split($str)[2]);
		}

		public function construct($inputText)
		{
			$root = [];
			$currentLevel = 1;

			$matches = null;
			$matches_count = preg_match_all($this->headersRegex, $inputText, $matches);

			return [
				'table_of_contents' => '',
				'text' => $inputText
			];
		}		
	}
?>