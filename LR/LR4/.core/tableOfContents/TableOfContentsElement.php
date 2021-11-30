<?php
	class TableOfContentsElement
	{
		private int $level;
		private string $content;
		private string $source;

		public function __construct($level, $content, $source)
		{
			$this->level = $level;
			$this->content = $content;
			$this->source = $source;
		}

		public function getLevel()
		{
			return $this->level;
		}

		public function getContent()
		{
			return $this->content;
		}

		public function getSource()
		{
			return $this->source;
		}
	}
?>