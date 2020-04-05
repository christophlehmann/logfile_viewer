<?php

$EM_CONF['logfile_viewer'] = [
    'title' => 'Logfile viewer',
    'description' => 'Backend module for viewing logfiles in typo3temp/var/log',
    'category' => 'plugin',
    'author' => 'Christoph Lehmann',
    'author_email' => 'post@christophlehmann.eu',
    'state' => 'stable',
    'version' => '0.1.0',
    'constraints' => [
        'depends' => [
            'typo3' => '9.5.0-10.5.99',
        ],
        'conflicts' => [],
        'suggests' => []
    ],
    'autoload' => [
        'psr-4' => [
            'Lemming\\LogfileViewer\\' => 'Classes'
        ]
    ]
];
