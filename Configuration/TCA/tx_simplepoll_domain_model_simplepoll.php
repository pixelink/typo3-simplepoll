<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

return [
    'ctrl' => [
        'title'	=> 'LLL:EXT:simplepoll/Resources/Private/Language/locallang_db.xlf:tx_simplepoll_domain_model_simplepoll',
        'label' => 'question',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'dividers2tabs' => true,
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'question,image,end_time,show_result_link,show_result_after_vote,allow_multiple_vote,answers,ip_locks,',
        'iconfile' => 'EXT:simplepoll/Resources/Public/Icons/ext_icon.png'
    ],
	'interface' => [
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, question, image, end_time, show_result_link, show_result_after_vote, allow_multiple_vote, answers, ip_locks',
	],
	'types' => [
		'1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, question, image, end_time, show_result_link, show_result_after_vote, allow_multiple_vote, answers, ip_locks, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
	],
	'palettes' => [
		'1' => ['showitem' => ''],
	],
	'columns' => [

        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'items' => [
                    [
                        'LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages',
                        -1,
                        'flags-multiple'
                    ],
                ],
                'default' => 0,
            ]
        ],
		'l10n_parent' => [
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => true,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => [
					['', 0],
				],
				'foreign_table' => 'tx_simplepoll_domain_model_simplepoll',
				'foreign_table_where' => 'AND tx_simplepoll_domain_model_simplepoll.pid=###CURRENT_PID### AND tx_simplepoll_domain_model_simplepoll.sys_language_uid IN (-1,0)',
			],
		],
		'l10n_diffsource' => [
			'config' => [
				'type' => 'passthrough',
			],
		],

		't3ver_label' => [
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			],
		],

		'hidden' => [
			'exclude' => true,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config' => [
				'type' => 'check',
			],
		],
		'starttime' => [
			'exclude' => true,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
			'config' => [
				'type' => 'input',
				'size' => 13,
				'eval' => 'datetime',
                'renderType' => 'inputDateTime',
				'checkbox' => 0,
				'default' => 0,
				'range' => [
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				],
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
			],
		],
		'endtime' => [
			'exclude' => true,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
			'config' => [
				'type' => 'input',
                'size' => 13,
				'eval' => 'datetime',
                'renderType' => 'inputDateTime',
				'checkbox' => 0,
				'default' => 0,
				'range' => [
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				],
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
			],
		],
		'question' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:simplepoll/Resources/Private/Language/locallang_db.xlf:tx_simplepoll_domain_model_simplepoll.question',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			],
		],
		'image' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:simplepoll/Resources/Private/Language/locallang_db.xlf:tx_simplepoll_domain_model_simplepoll.image',
			'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
				'image',
                ['maxitems' => 1],
				$GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'])
		],
		'end_time' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:simplepoll/Resources/Private/Language/locallang_db.xlf:tx_simplepoll_domain_model_simplepoll.end_time',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime',
                'default' => strtotime('+1 month')
            ],
		],
		'show_result_link' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:simplepoll/Resources/Private/Language/locallang_db.xlf:tx_simplepoll_domain_model_simplepoll.show_result_link',
			'config' => [
				'type' => 'check',
				'default' => 1
			],
		],
		'show_result_after_vote' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:simplepoll/Resources/Private/Language/locallang_db.xlf:tx_simplepoll_domain_model_simplepoll.show_result_after_vote',
			'config' => [
				'type' => 'check',
				'default' => 1
			],
		],
		'allow_multiple_vote' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:simplepoll/Resources/Private/Language/locallang_db.xlf:tx_simplepoll_domain_model_simplepoll.allow_multiple_vote',
			'config' => [
				'type' => 'check',
				'default' => 1
			],
		],
		'answers' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:simplepoll/Resources/Private/Language/locallang_db.xlf:tx_simplepoll_domain_model_simplepoll.answers',
			'config' => [
				'type' => 'inline',
				'foreign_table' => 'tx_simplepoll_domain_model_answer',
				'foreign_field' => 'simplepoll',
				'foreign_sortby' => 'sorting',
				'maxitems'      => 9999,
				'appearance' => [
					'collapseAll' => true,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => true,
					'showPossibleLocalizationRecords' => true,
					'useSortable' => 1,
					'showAllLocalizationLink' => true
				],
			],

		],
		'ip_locks' => [
			'exclude' => true,
			'label' => 'LLL:EXT:simplepoll/Resources/Private/Language/locallang_db.xlf:tx_simplepoll_domain_model_simplepoll.ip_locks',
			'config' => [
				'type' => 'inline',
				'foreign_table' => 'tx_simplepoll_domain_model_iplock',
				'foreign_field' => 'simplepoll',
				'maxitems'      => 9999,
				'appearance' => [
					'collapseAll' => true,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => true,
					'showPossibleLocalizationRecords' => true,
					'showAllLocalizationLink' => true
				],
			],
		],
	],
];
