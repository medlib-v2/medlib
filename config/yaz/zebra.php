<?php

return [

    'BNF' => [
        'fullname' => 'BN Fance',
        'instance' => 'BNF',
        'database' => [
            'hostname' => 'z3950.bnf.fr',
            'port' => 2211,
            'name' => ['TOUT-UTF8', 'TOUT'],
            'format' => 'unimarc',
            'elementset' => 'F',
        ],
        'options' => [
            'user' => 'Z3950',
            'password' => 'Z3950_BNF',
            'charset' => 'UTF-8',
            'preferredMessageSize' => 10240,
            'maximumRecordSize' => 10240,

        ],
    ],

    'OPAC' => [
        'fullname' => 'OPAC SBN',
        'instance' => 'OPAC',
        'database' => [
            'hostname' => 'opac.sbn.it',
            'port' => 2100,
            'name' => ['nopac'],
            'format' => 'UNIMARC',
        ],
        'options' => [
            'charset' => 'UTF-8',
            'preferredMessageSize' => 10240,
            'maximumRecordSize' => 10240,

        ],
    ],

    /**
     * Address: z3950.copac.ac.uk
     * Port: 210
     * Database name: COPAC
     * Record syntax: XML or SUTRS
     *
    'COPAC' => [
        'fullname' => 'COPAC',
        'instance' => 'COPAC',
        'database' => [
            'hostname' => 'z3950.copac.ac.uk',
            'port' => 210,
            'name' => ['COPAC'],
            'format' => 'XML',
            'elementset' => 'F',

        ],
        'options' => [
            'charset' => 'UTF-8',
            'preferredMessageSize' => 10240,
            'maximumRecordSize' => 10240,

        ],
    ],
    */

    'VOYAGE' => [
        'fullname' => 'Library Of Congress',
        'instance' => 'VOYAGE',
        'database' => [
            'hostname' => 'z3950.loc.gov',
            'port' => 7090,
            'name' => ['voyager'],
            'format' => 'marc21', // ou USMARC
            'elementset' => 'F',

        ],
        'options' => [
            'charset' => 'UTF-8',
            'preferredMessageSize' => 10240,
            'maximumRecordSize' => 10240,

        ],
    ],

    'SUDOC' => [
        'fullname' => 'SUDOC',
        'instance' => 'SUDOC',
        'database' => [
            'hostname' => 'carmin.sudoc.abes.fr',
            'port' => 210,
            'name' => ['abes-z39-public'],
            'format' => 'UNIMARC',
            'elementset' => 'F',
        ],
        'options' => [
            'charset' => 'UTF-8',
            'preferredMessageSize' => 10240,
            'maximumRecordSize' => 10240,

        ],
    ],

    'LCDB' => [
        'fullname' => 'Library of Congress Online Catalog',
        'instance' => 'LCDB',
        'database' => [
            'hostname' => 'lx2.loc.gov',
            'port' => 210,
            'name' => ['LCDB'],
            'format' => 'MARCXML',
            'elementset' => 'F',

        ],
        'options' => [
            'user' => 'SUNCAT',
            'password' => 'SUNCAT',
            'charset' => 'UTF-8',
            'preferredMessageSize' => 10240,
            'maximumRecordSize' => 10240,

        ],
    ],

    /**
    'ULQC' => [
        'fullname' => 'Univ Laval (QC)',
        'instance' => 'ULQC',
        'database' => [
            'hostname' => 'ariane2.ulaval.ca',
            'port' => 2200,
            'name' => ['UNICORN'],
            'format' => 'USMARC',
            'elementset' => 'F',

        ],
        'options' => [
            'charset' => 'UTF-8',
            'preferredMessageSize' => 10240,
            'maximumRecordSize' => 10240,

        ],
    ],
    */

    /**
    'UNOX' => [
        'fullname' => 'Univ Oxford',
        'instance' => 'UNOX',
        'database' => [
            'hostname' => 'library.ox.ac.uk',
            'port' => 210,
            'name' => ['ADVANCE'],
            'format' => 'USMARC',
            'elementset' => 'F',

        ],
        'options' => [
            'user' => 'SUNCAT',
            'password' => 'SUNCAT',
            'charset' => 'UTF-8',
            'preferredMessageSize' => 10240,
            'maximumRecordSize' => 10240,

        ],
    ],
    */

    'UCL' => [
        'fullname' => 'Libellule | Université Catholique de Louvain',
        'instance' => 'UCL',
        'database' => [
            'hostname' => 'bib.sipr.ucl.ac.be',
            'port' => 3590,
            'name' => ['DEFAULT'],
            'format' => 'unimarc',
            'elementset' => 'F',
        ],
        'options' => [
            'charset' => 'UTF-8',
            'preferredMessageSize' => 10240,
            'maximumRecordSize' => 10240,

        ],
    ],

    'NLC' => [
        'fullname' => 'Bibliothèque et Archives Canada',
        'instance' => 'NLC',
        'database' => [
            'hostname' => 'amicus.collectionscanada.gc.ca',
            'port' => 210,
            'name' => ['ANY', 'UC', 'NL', 'LC', 'FS', 'NA', 'NFB', 'SE', 'AU'],
            'format' => 'MARC21',
            'elementset' => 'F',
        ],
        'options' => [
            'charset' => 'UTF-8',
            'preferredMessageSize' => 10240,
            'maximumRecordSize' => 10240,

        ],
    ],
];