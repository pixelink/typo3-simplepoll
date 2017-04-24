<?php

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Simple Poll',
	'description' => 'An easy to setup and use poll system',
	'category' => 'plugin',
	'author' => 'Alex Bigott / Pixel Ink',
	'author_email' => 'support@pixel-ink.de',
	'state' => 'stable',
	'internal' => '',
	'uploadfolder' => '1',
	'createDirs' => '',
	'clearCacheOnLoad' => 1,
	'version' => '2.0.0',
	'constraints' => [
		'depends' => [
			'typo3' => '6.2.0-8.7.99',
		],
		'conflicts' => [
		],
		'suggests' => [
		],
	],
);