<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Pixelink.' . $_EXTKEY,
	'Polllisting',
	array(
		'SimplePoll' => 'list,vote,seeVotes,message',
	),
	// non-cacheable actions
	array(
		'SimplePoll' => 'list,vote,seeVotes,message',
	)
);
