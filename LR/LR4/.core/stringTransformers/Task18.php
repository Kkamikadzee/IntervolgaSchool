<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . '/LR4/.core/stringTransformers/IStringTransformer.php');	

	class Task18 implements IStringTransformer
	{
 		private $paragraphRegex = '/(<p>[\s\S]*?<\/p>)/u';
 		private $wordRegex = '/\b\w+(-\w+)?\b/ui';
		private $countWordForMark = 3;
		private $markFormat = '<span style="background-color: #ffffaa">%s</span>';

		private function getParagraphsContent($inputText)
		{
			$matches = null;
			$matches_count = preg_match_all($this->paragraphRegex, $inputText, $matches);
			$matches = $matches[0];
			
			if ($matches_count === false)
			{
				return null;
			}

			return $matches;
		}

		private function markWordInString($str, $word)
		{
			return preg_replace('/\b' . $word . '\b/ui', sprintf($this->markFormat, $word), $str);
		}

		private function getWordsToMark($content)
		{
			$words = null;
			$words_count = preg_match_all($this->wordRegex, strip_tags($content), $words);
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

			$markedWords = null;
			foreach ($words_counter as $word => $count)
			{
				if($count >= $this->countWordForMark)
				{
					$markedWords[] = $word;
				}
			}

			return $markedWords;
		}

		private function markRepetitonOfWordsInParagraph($content)
		{
			$words = $this->getWordsToMark($content);

			if(!$words)
			{
				return null;
			}

			foreach($words as &$word)
			{
				$content = $this->markWordInString($content, $word);
			}

			return $content;
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
			//$sortKey = array_map('strlen', array_keys($markedReperion));
			//array_multisort($markedReperion, SORT_NUMERIC, $sortKey);
			//$markedReperion = array_reverse($markedReperion);

			foreach ($markedReperion as $search => $replace)
			{
				$inputText = str_replace($search, $replace, $inputText);
			}
			return $inputText;
		}		
	}
?>