<?php
	class TableOfContents
	{
		private $tableOfContentsView;
		private $textWithLinks;

		public function __construct($tableOfContentsView, $textWithLinks)
		{
			$this->tableOfContentsView = $tableOfContentsView;
			$this->textWithLinks = $textWithLinks;
		}

		public function getTableOfContentsView()
		{
			return $this->tableOfContentsView;
		}

		public function getTextWithLinks()
		{
			return $this->textWithLinks;
		}
	}
?>