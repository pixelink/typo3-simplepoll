<?php
defined('TYPO3_MODE') or die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Pixelink.' . $_EXTKEY,
	'Polllisting',
	[
		'SimplePoll' => 'list,vote,seeVotes,message',
	],
	// non-cacheable actions
	[
		'SimplePoll' => 'list,vote,seeVotes,message',
	]
);
