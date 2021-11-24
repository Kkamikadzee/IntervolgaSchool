<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . '/LR4/.core/stringTransformers/IStringTransformer.php');	

	class Task4 implements IStringTransformer
	{
 		private $adverbs = ['кто', 'где', 'когда', 'что', 'куда', 'откуда', 'почему', 'зачем', 'как'];
		private $particles = ['нибудь', 'либо', 'то'];
		private $interjectionsDictionary = ['из за', 'из под','ну ка', 'ну кась', 'ей де','то то', 'вот вот'];

		public function __construct()
		{

		}

		public function replace($inputText)
		{
			foreach ($this->adverbs as &$adverb)
			{
				foreach ($this->particles as &$particle)
				{						
					$inputText = preg_replace('/((\b)' . $adverb . ')\s(' . $particle . '(\b))/ui', '\1-\3', $inputText);
				}
			}

			foreach ($this->interjectionsDictionary as &$interjection)
			{
				$parts =  explode(' ', $interjection);
				$inputText = preg_replace('/((\b)' . $parts[0] . ')\s(' . $parts[1] . '(\b))/ui', '\1-\3', $inputText);
			}

			return $inputText;
		}		
	}
?>