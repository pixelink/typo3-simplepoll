<?php
defined('TYPO3_MODE') or die();

call_user_func(function () {
    $coreVersion = substr(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getExtensionVersion('core'), 1, 4);
    $controller = \Pixelink\Simplepoll\Controller\SimplePollController::class;

    if (version_compare($coreVersion, '11.0', '<')) {
        $controller = 'SimplePoll';
    }

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Pixelink.simplepoll',
        'Polllisting',
        [
            $controller => 'list,vote,seeVotes,message',
        ],
        // non-cacheable actions
        [
            $controller => 'list,vote,seeVotes,message',
        ]
    );
});
