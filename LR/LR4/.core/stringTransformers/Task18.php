<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . '/LR4/.core/stringTransformers/IStringTransformer.php');	

	class Task18 implements IStringTransformer
	{
 		private $paragraphRegex = '/(<p>[\s\S]*?<\/p>)/u';
 		private $wordRegex = '/\b\w+(-\w+)?\b/u';
		private $countWordForMark = 3;
		private $markFormat = '<span style="background-color: #ffffaa">%s</span>';

		private function getParagraphsContent($inputText)
		{
			$matches = null;
			$matches_count = preg_match_all($this->paragraphRegex, $inputText, $matches);
			
			if ($matches_count === false)
			{
				return null;
			}

			$paragraphsContent = array();
			foreach ($matches[0] as &$match)
			{
				$paragraphsContent[] = mb_substr($match, 3, -4);
			}

			return $paragraphsContent;
		}

		private function markWordInString($str, $word)
		{
			return str_replace($word, sprintf($this->markFormat, $word), $str);
		}

		private function markRepetitonOfWordsInParagraph($content)
		{
			$words = null;
			$words_count = preg_match_all($this->wordRegex, $content, $words);
			$words = $words[0];

			if($words_count === false)
			{
				return null;
			}

			$words_counter = array();
			foreach ($words as &$word)
			{
				if(array_key_exists($word, $words_counter))
				{
					$words_counter[$word]++;
				}
				else
				{
					$words_counter[$word] = 1;
				}
			}

			$markedContent = null;
			foreach ($words_counter as $word => $count)
			{
				if($count >= $this->countWordForMark)
				{
					if(is_null($markedContent))
					{
						$markedContent = $content;
					}

					$markedContent = $this->markWordInString($markedContent, $word);
				}
			}

			return $markedContent;
		}

		private function markRepetitonOfWords($paragraphsContent)
		{
			$replacementPairs = array();
			foreach ($paragraphsContent as &$content)
			{
				$replacementPairs[$content] = $this->markRepetitonOfWordsInParagraph($content);
			}

			return array_filter($replacementPairs);
		}

		public function __construct()
		{
			
		}

		public function replace($inputText)
		{
			$paragraphsContent = $this->getParagraphsContent($inputText);

			$markedReperion = $this->markRepetitonOfWords($paragraphsContent);
			$sortKey = array_map('strlen', array_keys($markedReperion));
			array_multisort($markedReperion, SORT_NUMERIC, $sortKey);
			$markedReperion = array_reverse($markedReperion);

			foreach ($markedReperion as $search => $replace)
			{
				$inputText = str_replace($search, $replace, $inputText);
			}
			return $inputText;
		}		
	}
?>