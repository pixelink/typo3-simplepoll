<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$GLOBALS['TCA']['tx_simplepoll_domain_model_simplepoll'] = array(
	'ctrl' => $GLOBALS['TCA']['tx_simplepoll_domain_model_simplepoll']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, question, image, end_time, show_result_link, show_result_after_vote, allow_multiple_vote, answers, ip_locks',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, question, image, end_time, show_result_link, show_result_after_vote, allow_multiple_vote, answers, ip_locks, --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access, starttime, endtime'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
	
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_simplepoll_domain_model_simplepoll',
				'foreign_table_where' => 'AND tx_simplepoll_domain_model_simplepoll.pid=###CURRENT_PID### AND tx_simplepoll_domain_model_simplepoll.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),

		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
	
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),

		'question' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:simplepoll/Resources/Private/Language/locallang_db.xlf:tx_simplepoll_domain_model_simplepoll.question',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'image' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:simplepoll/Resources/Private/Language/locallang_db.xlf:tx_simplepoll_domain_model_simplepoll.image',
			'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
				'image',
				array('maxitems' => 1),
				$GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
			),
		),
		'end_time' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:simplepoll/Resources/Private/Language/locallang_db.xlf:tx_simplepoll_domain_model_simplepoll.end_time',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'datetime',
				'checkbox' => 1,
				'default' => time()
			),
		),
		'show_result_link' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:simplepoll/Resources/Private/Language/locallang_db.xlf:tx_simplepoll_domain_model_simplepoll.show_result_link',
			'config' => array(
				'type' => 'check',
				'default' => 1
			)
		),
		'show_result_after_vote' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:simplepoll/Resources/Private/Language/locallang_db.xlf:tx_simplepoll_domain_model_simplepoll.show_result_after_vote',
			'config' => array(
				'type' => 'check',
				'default' => 1
			)
		),
		'allow_multiple_vote' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:simplepoll/Resources/Private/Language/locallang_db.xlf:tx_simplepoll_domain_model_simplepoll.allow_multiple_vote',
			'config' => array(
				'type' => 'check',
				'default' => 1
			)
		),
		'answers' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:simplepoll/Resources/Private/Language/locallang_db.xlf:tx_simplepoll_domain_model_simplepoll.answers',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_simplepoll_domain_model_answer',
				'foreign_field' => 'simplepoll',
				'maxitems'      => 9999,
				'appearance' => array(
					'collapseAll' => 1,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'useSortable' => 1,
					'showAllLocalizationLink' => 1
				),
			),

		),
		'ip_locks' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:simplepoll/Resources/Private/Language/locallang_db.xlf:tx_simplepoll_domain_model_simplepoll.ip_locks',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_simplepoll_domain_model_iplock',
				'foreign_field' => 'simplepoll',
				'maxitems'      => 9999,
				'appearance' => array(
					'collapseAll' => 1,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),

		),
		
	),
);
