<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . '/LR4/.core/tableOfContents/TableOfContentsElement.php');

	class TableOfContentsConstructor
	{
 		private $headersRegex = '/(<h1.*?>[\s\S]*?<\/h1>)|(<h2.*?>[\s\S]*?<\/h2>)|(<h3.*?>[\s\S]*?<\/h3>)/u';

		public function __construct()
		{

		}

		private function getHeaderLevel($str)
		{
			return intval(mb_str_split($str)[2]);
		}

		public function construct($inputText)
		{
			$matches = null;
			$matches_count = preg_match_all($this->headersRegex, $inputText, $matches);
			$matches = $matches[0];

			if($matches_count === false)
			{
				return null;
			}

			$tableOfContents = array();
			foreach ($matches as &$match)
			{
				$tableOfContents[] = new TableOfContentsElement($this->getHeaderLevel($match), strip_tags($match), $match);
			}

			return $tableOfContents;
		}		
	}
?>