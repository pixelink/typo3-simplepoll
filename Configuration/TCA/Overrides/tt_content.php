<?php
defined('TYPO3_MODE') or die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'simplepoll',
    'Polllisting',
    'Simple Poll'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('simplepoll', 'Configuration/TypoScript', 'Simple Poll Extension');

// include the flexform for the plugin
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['simplepoll_polllisting'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('simplepoll_polllisting', 'FILE:EXT:simplepoll/Configuration/FlexForms/flexform_simplepoll.xml');
