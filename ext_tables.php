<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
    version_compare(\TYPO3\CMS\Core\Utility\VersionNumberUtility::getNumericTypo3Version(), '10.1', '<') ? 'Lemming.LogfileViewer' : 'LogfileViewer',
    'system',
    'tx_logfileViewer',
    '',
    [
        \Lemming\LogfileViewer\Controller\LogfileController::class => 'index, show, delete, download'
    ],
    [
        'access' => 'group,user',
        'icon' => 'EXT:logfile_viewer/Resources/Public/Icons/module-logfileviewer.svg',
        'labels' => 'LLL:EXT:logfile_viewer/Resources/Private/Language/locallang_mod.xlf',
    ]
);
