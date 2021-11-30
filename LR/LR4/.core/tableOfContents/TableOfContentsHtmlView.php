<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . '/LR4/.core/tableOfContents/TableOfContentsElement.php');
	require_once($_SERVER['DOCUMENT_ROOT'] . '/LR4/.core/tableOfContents/TableOfContents.php');

	class TableOfContentsHtmlView
	{
		private function goToNextLevel($doc, &$node, &$currentLevel)
		{
			$nextNode = $doc->createElement('ul');
			$node->appendChild($nextNode);
			$node = $nextNode;

			$currentLevel++;
		}

		private function goToPreviousLevel(&$node, &$currentLevel)
		{
			$node = $node->parentNode;

			$currentLevel--;
		}

		private function addElement($doc, &$node, &$currentLevel, $element, &$text, &$hrefCounter)
		{
			while($element->getLevel() != $currentLevel)
			{
				if($element->getLevel() > $currentLevel)
				{
					$this->goToNextLevel($doc, $node, $currentLevel);
				}
				elseif($element->getLevel() < $currentLevel)
				{
					$this->goToPreviousLevel($node, $currentLevel);
				}
			}
			
			$aElementContent = $element->getContent();
			if(strlen($aElementContent) >= 50)
			{
				$aElementContent = mb_substr($aElementContent, 0, 50) . '…';
			}

			$aElement = $doc->createElement('a', $aElementContent);
			$aAttribute = $doc->createAttribute('href');
			$aAttribute->value = '#toc_tag_' . ++$hrefCounter;
			$aElement->appendChild($aAttribute);

			$liElement = $doc->createElement('li');
			$liElement->appendChild($aElement);

			$node->appendChild($liElement);

			$text = str_replace($element->getSource(), '<a name="' . mb_substr($aAttribute->value, 1) . '"></a>' . $element->getSource(), $text);
		}

		public function __construct()
		{
			
		}

		public function construct($inputText, $rawTableOfContents)
		{
			$doc = new DOMDocument();
			$node = $doc;
			$currentLevel = 0;
			$hrefCounter = 0;
			$resultText = $inputText;

			foreach($rawTableOfContents as &$tableOfContentsElement)
			{
				$this->addElement($doc, $node, $currentLevel, $tableOfContentsElement, $resultText, $hrefCounter);
			}

			while(true)
			{
				if(!$node->parentNode)
				{
					$node = $node->parentNode;
				}
				else
				{
					break;
				}
			}

			return new TableOfContents($doc->saveHTML(), $resultText);
		}		
	}
?>