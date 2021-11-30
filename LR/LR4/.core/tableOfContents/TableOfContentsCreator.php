<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . '/LR4/.core/tableOfContents/TableOfContentsConstructor.php');
	require_once($_SERVER['DOCUMENT_ROOT'] . '/LR4/.core/tableOfContents/TableOfContentsHtmlView.php');
	require_once($_SERVER['DOCUMENT_ROOT'] . '/LR4/.core/tableOfContents/TableOfContents.php');

	class TableOfContentsCreator
	{
 		private $constructor;
		private $view;

		public function __construct()
		{
			$this->constructor = new TableOfContentsConstructor();
			$this->view = new TableOfContentsHtmlView();
		}

		public function create($inputText)
		{
			$rawTableOfContents = $this->constructor->construct($inputText);

			if(!$rawTableOfContents)
			{
				return null;
			}
			
			return $this->view->construct($inputText, $rawTableOfContents);
		}
	}
?>