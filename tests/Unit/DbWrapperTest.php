<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace vaniacarta74\Crud\tests\Unit;

use PHPUnit\Framework\TestCase;
use vaniacarta74\Crud\DbWrapper;

/**
 * Description of DbWrapperTest
 *
 * @author Vania
 */
class DbWrapperTest extends TestCase
{
    /**
     * @group dbWrapper
     * @coversNothing
     */
    public function dateTimeProvider()
    {
        $data = [
            'all' => [
                'host' => 'h1',
                'dbName' => 'dbcore',
                'purgedQuery' => [
                    'fields' => [
                        0 => [
                            'name' => 'COUNT(*)',
                            'alias' => 'n_record',
                            'type' => 'integer'
                        ]
                    ],
                    'table' => 'variabili_sync',
                    'where' => [],
                    'order' => [],
                    'type' => 'all'
                ],
                'validParams' => [],
                'expecteds' => [                    
                    'type' => 'all',
                    'records' => [
                        0 => [
                            'n_record' => '44',
                        ]
                    ],
                    'id' => null                    
                ]    
            ],
            'read' => [
                'host' => 'h1',
                'dbName' => 'SPT',
                'purgedQuery' => [
                    'fields' => [
                        0 => [
                            'name' => 'id_dato',
                            'alias' => 'id',
                            'type' => 'integer'
                        ],
                        1 => [
                            'name' => 'variabile',
                            'alias' => null,
                            'type' => 'integer'
                        ],
                        2 => [
                            'name' => 'valore',
                            'alias' => null,
                            'type' => 'float'
                        ],
                        3 => [
                            'name' => 'CONVERT(varchar, data_e_ora, 20)',
                            'alias' => 'data_e_ora',
                            'type' => 'dateTime'
                        ],
                        4 => [
                            'name' => 'tipo_dato',
                            'alias' => null,
                            'type' => 'integer'
                        ]
                    ],
                    'table' => 'dati_acquisiti',
                    'where' => [
                        'and' => [
                            0 => [
                                'field' => 'id_dato',
                                'operator' => '=',
                                'value' => [
                                    'param' => 'id',
                                    'bind' => ':id_dato',
                                    'type' => 'int',
                                    'null' => false,
                                    'check' => [
                                        'type' => 'integer',
                                        'params' => []
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'order' => [],
                    'type' => 'read'
                ],
                'validParams' => [
                    0 => [
                        'param' => 'id',
                        'bind' => ':id_dato',
                        'type' => 'int',
                        'null' => false,
                        'check' => [
                            'type' => 'integer',
                            'params' => []
                        ],
                        'value' => '97047202'
                    ]
                ],
                'expecteds' => [                    
                    'type' => 'read',
                    'records' => [
                        0 => [
                            'id' => '97047202',
                            'variabile' => '82025',
                            'valore' => '0',
                            'data_e_ora' => '28/10/2018 02:00:00',
                            'tipo_dato' => '2'
                        ]
                    ],
                    'id' => '97047202'                    
                ]    
            ],
            'list' => [
                'host' => 'h1',
                'dbName' => 'SPT',                
                'purgedQuery' => [
                    'fields' => [
                        0 => [
                            'name' => 'id_dato',
                            'alias' => 'id',
                            'type' => 'integer'
                        ],
                        1 => [
                            'name' => 'variabile',
                            'alias' => null,
                            'type' => 'integer'
                        ],
                        2 => [
                            'name' => 'valore',
                            'alias' => null,
                            'type' => 'float'
                        ],
                        3 => [
                            'name' => 'CONVERT(varchar, data_e_ora, 20)',
                            'alias' => 'data_e_ora',
                            'type' => 'dateTime'
                        ],
                        4 => [
                            'name' => 'tipo_dato',
                            'alias' => null,
                            'type' => 'integer'
                        ]
                    ],
                    'table' => 'dati_acquisiti',
                    'where' => [
                        'and' => [
                            0 => [
                                'field' => 'variabile',
                                'operator' => '=',
                                'value' => [
                                    'param' => 'var',
                                    'bind' => ':variabile',
                                    'type' => 'int',
                                    'null' => false,
                                    'check' => [
                                        'type' => 'integer',
                                        'params' => []
                                    ]
                                ]
                            ],
                            1 => [
                                'field' => 'tipo_dato',
                                'operator' => '=',
                                'value' => [
                                    'param' => 'type',
                                    'bind' => ':tipoDato',
                                    'type' => 'int',
                                    'null' => false,
                                    'check' => [
                                        'type' => 'enum',
                                        'params' => [
                                            0 => [
                                                0 => 1,
                                                1 => 2
                                            ]
                                        ]
                                    ]
                                ]
                            ],
                            2 => [
                                'field' => 'data_e_ora',
                                'operator' => '>=',
                                'value' => [
                                    'param' => 'datefrom',
                                    'bind' => ':dataIniziale',
                                    'type' => 'str',
                                    'null' => false,
                                    'check' => [
                                        'type' => 'dateTime',
                                        'params' => [
                                            0 => true
                                        ]
                                    ]
                                ]
                            ],
                            3 => [
                                'field' => 'data_e_ora',
                                'operator' => '<',
                                'value' => [
                                    'param' => 'dateto',
                                    'bind' => ':dataFinale',
                                    'type' => 'str',
                                    'null' => false,
                                    'check' => [
                                        'type' => 'dateTime',
                                        'params' => [
                                            0 => true
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'order' => [
                        0 => [
                            'field' => 'data_e_ora',
                            'type' => 'asc'
                        ]
                    ],
                    'type' => 'list'
                ],
                'validParams' => [
                    0 => [
                        'param' => 'var',
                        'bind' => ':variabile',
                        'type' => 'int',
                        'null' => false,
                        'check' => [
                            'type' => 'integer',
                            'params' => []
                        ],
                        'value' => '82025'
                    ],
                    1 => [
                        'param' => 'type',
                        'bind' => ':tipoDato',
                        'type' => 'int',
                        'null' => false,
                        'check' => [
                            'type' => 'enum',
                            'params' => [
                                0 => [
                                    0 => 1,
                                    1 => 2
                                ]
                            ]
                        ],
                        'value' => '2'
                    ],
                    2 => [
                        'param' => 'datefrom',
                        'bind' => ':dataIniziale',
                        'type' => 'str',
                        'null' => false,
                        'check' => [
                            'type' => 'dateTime',
                            'params' => [
                                0 => true
                            ]
                        ],
                        'value' => '28/10/2018T01:00:00'
                    ],
                    3 => [
                        'param' => 'dateto',
                        'bind' => ':dataFinale',
                        'type' => 'str',
                        'null' => false,
                        'check' => [
                            'type' => 'dateTime',
                            'params' => [
                                0 => true
                            ]
                        ],
                        'value' => '28/10/2018T01:30:00'
                    ]
                ],
                'expecteds' => [
                    'type' => 'list',
                    'records' => [
                        0 => [
                            'id' => '97047200',
                            'variabile' => '82025',
                            'valore' => '0',
                            'data_e_ora' => '28/10/2018 01:00:00',
                            'tipo_dato' => '2'
                        ]
                    ],
                    'id' => null
                ]    
            ],
            'create' => [
                'host' => 'h1',
                'dbname' => 'SPT',
                'purgedQuery' => [                        
                    'table' => 'dati_acquisiti',
                    'type' => 'create',
                    'values' => [
                        0 => [
                            'field' => 'variabile',
                            'value' => [
                                'param' => 'var',
                                'bind' => ':variabile',
                                'type' => 'int',
                                'null' => false,
                                'check' => [
                                    'type' => 'integer',
                                    'params' => []
                                ]
                            ]
                        ],
                        1 => [
                            'field' => 'tipo_dato',
                            'value' => [
                                'param' => 'type',
                                'bind' => ':tipoDato',
                                'type' => 'int',
                                'null' => false,
                                'check' => [
                                    'type' => 'enum',
                                    'params' => [
                                        0 => [
                                            0 => 1,
                                            1 => 2
                                        ]
                                    ]
                                ]
                            ]
                        ],
                        2 => [
                            'field' => 'data_e_ora',
                            'value' => [
                                'param' => 'date',
                                'bind' => ':data_e_ora',
                                'type' => 'str',
                                'null' => false,
                                'check' => [
                                    'type' => 'dateTime',
                                    'params' => [
                                        0 => true
                                    ]
                                ]
                            ]
                        ],
                        3 => [
                            'field' => 'valore',
                            'value' => [
                                'param' => 'val',
                                'bind' => ':valore',
                                'type' => 'int',
                                'null' => false,
                                'check' => [
                                    'type' => 'float',
                                    'params' => []
                                ]
                            ]
                        ]
                    ]
                ],
                'validParams' => [
                    0 => [
                        'param' => 'var',
                        'bind' => ':variabile',
                        'type' => 'int',
                        'null' => false,
                        'check' => [
                            'type' => 'integer',
                            'params' => []
                        ],
                        'value' => '82025'
                    ],
                    1 => [
                        'param' => 'type',
                        'bind' => ':tipoDato',
                        'type' => 'int',
                        'null' => false,
                        'check' => [
                            'type' => 'enum',
                            'params' => [
                                0 => [
                                    0 => 1,
                                    1 => 2
                                ]
                            ]
                        ],
                        'value' => '2'
                    ],
                    2 => [
                        'param' => 'date',
                        'bind' => ':data_e_ora',
                        'type' => 'str',
                        'null' => false,
                        'check' => [
                            'type' => 'dateTime',
                            'params' => [
                                0 => true
                            ]
                        ],
                        'value' => '28/10/2018T01:00:00'
                    ],
                    3 => [
                        'param' => 'val',
                        'bind' => ':valore',
                        'type' => 'int',
                        'null' => false,
                        'check' => [
                            'type' => 'float',
                            'params' => []
                        ],
                        'value' => '3.5'
                    ]
                ],
                'expecteds' => [
                    'type' => 'create',                    
                    'id' => '@id@'
                ]    
            ],
            'update' => [
                'host' => 'h1',
                'dbName' => 'SPT',
                'purgedQuery' => [                        
                    'table' => 'dati_acquisiti',
                    'type' => 'update',
                    'set' => [                            
                        2 => [
                            'field' => 'data_e_ora',
                            'value' => [
                                'param' => 'date',
                                'bind' => ':data_e_ora',
                                'type' => 'str',
                                'null' => true,
                                'check' => [
                                    'type' => 'dateTime',
                                    'params' => [
                                        0 => true
                                    ]
                                ]
                            ]
                        ],
                        3 => [
                            'field' => 'valore',
                            'value' => [
                                'param' => 'val',
                                'bind' => ':valore',
                                'type' => 'int',
                                'null' => true,
                                'check' => [
                                    'type' => 'float',
                                    'params' => []
                                ]
                            ]
                        ]
                    ],
                    'where' => [
                        'and' => [
                            0 => [
                                'field' => 'id_dato',
                                'operator' => '=',
                                'value' => [
                                    'param' => 'id',
                                    'bind' => ':id_dato',
                                    'type' => 'int',
                                    'null' => false,
                                    'check' => [
                                        'type' => 'integer',
                                        'params' => []
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                'validParams' => [
                    2 => [
                        'param' => 'date',
                        'bind' => ':data_e_ora',
                        'type' => 'str',
                        'null' => true,
                        'check' => [
                            'type' => 'dateTime',
                            'params' => [
                                0 => true
                            ]
                        ],
                        'value' => '20/10/2018T01:30:00'
                    ],
                    3 => [
                        'param' => 'val',
                        'bind' => ':valore',
                        'type' => 'int',
                        'null' => true,
                        'check' => [
                            'type' => 'float',
                            'params' => []
                        ],
                        'value' => '1.9'
                    ],
                    6 => [
                        'param' => 'id',
                        'bind' => ':id_dato',
                        'type' => 'int',
                        'null' => false,
                        'check' => [
                            'type' => 'integer',
                            'params' => []
                        ],
                        'value' => '101540010'
                    ]
                ],
                'expecteds' => [
                    'type' => 'update',
                    'id' => '101540010'
                ]    
            ],
            'delete' => [
                'host' => 'h1',
                'dbName' => 'SPT',
                'purgedQuery' => [                        
                    'table' => 'dati_acquisiti',
                    'type' => 'delete',
                    'where' => [
                        'and' => [
                            0 => [
                                'field' => 'id_dato',
                                'operator' => '=',
                                'value' => [
                                    'param' => 'id',
                                    'bind' => ':id_dato',
                                    'type' => 'int',
                                    'null' => false,
                                    'check' => [
                                        'type' => 'integer',
                                        'params' => []
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                'validParams' => [
                    0 => [
                        'param' => 'id',
                        'bind' => ':id_dato',
                        'type' => 'int',
                        'null' => false,
                        'check' => [
                            'type' => 'integer',
                            'params' => []
                        ],
                        'value' => '@id@'
                    ]
                ], 
                'expecteds' => [
                    'type' => 'delete',
                    'id' => '@id@'
                ]    
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group dbWrapper
     * @covers \vaniacarta74\Crud\DbWrapper::dateTime
     * @dataProvider dateTimeProvider
     */
    public function testDateTimeEquals($host, $dbName, $purgedQuery, $validParams, $expected)
    {
        $jsonId = file_get_contents(__DIR__ . '/../providers/wrapper.json');
        $arrJson = json_decode($jsonId, true);
        $newId = $arrJson['id_dato'];
        $method = $purgedQuery['type'];
        
        if ($method === 'delete') {            
            $validParams[0]['value'] = str_replace('@id@', $newId, $validParams[0]['value']);
            $expected['id'] = str_replace('@id@', $newId, $expected['id']);
        }
        
        if ($method === 'create') {            
            $expected['id'] = str_replace('@id@', $newId, $expected['id']);
        }
        
        $actual = DbWrapper::dateTime($host, $dbName, $purgedQuery, $validParams);
        
        $this->assertEquals($expected, $actual);
        
        if ($method === 'delete') {            
            file_put_contents(__DIR__ . '/../providers/wrapper.json','{"id_dato":' . ($newId + 1) . '}');
        }
    }
    
    /**
     * @group dbWrapper
     * @coversNothing
     */
    public function dateTimeExceptionProvider()
    {
        $data = [
            'pdo' => [
                'host' => 'h1',
                'dbname' => 'SPT',
                'query' => [
                    'fields' => [
                        0 => [
                            'name' => 'id_dati',
                            'alias' => 'id',
                            'type' => 'integer'
                        ]
                    ],
                    'table' => 'dati_acquisiti',
                    'where' => [
                        'and' => [
                            0 => [
                                'field' => 'id_dato',
                                'operator' => '=',
                                'value' => [
                                    'param' => 'id',
                                    'bind' => ':id_dato',
                                    'type' => 'int',
                                    'null' => false,
                                    'check' => [
                                        'type' => 'integer',
                                        'params' => []
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'order' => [],
                    'type' => 'read'
                ],
                'params' => [
                    0 => [
                        'param' => 'id',
                        'bind' => ':id_dato',
                        'type' => 'int',
                        'null' => false,
                        'check' => [
                            'type' => 'integer',
                            'params' => []
                        ],
                        'value' => '97047202'
                    ]
                ]
            ],
            'no string host' => [
                'host' => [],
                'dbname' => 'SPT',
                'query' => [],
                'params' => []
            ],
            'no string db' => [
                'host' => 'h1',
                'dbname' => [],
                'query' => [],
                'params' => []
            ],
            'no array query' => [
                'host' => 'h1',
                'dbname' => 'SPT',
                'query' => 'pippo',
                'params' => []
            ],
            'no array params' => [
                'host' => 'h1',
                'dbname' => 'SPT',
                'query' => [],
                'params' => 'pippo'
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group dbWrapper
     * @covers \vaniacarta74\Crud\DbWrapper::dateTime
     * @dataProvider dateTimeExceptionProvider
     */
    public function testDateTimeException($host, $dbName, $purgedQuery, $validParams)
    {
        $this->setExpectedException('Exception');
        
        DbWrapper::dateTime($host, $dbName, $purgedQuery, $validParams);
    }
    
    /**
     * @group dbWrapper
     * @coversNothing
     */
    public function setDateTimeParamsProvider()
    {
        $data = [
            'spt' => [
                'dbName' => 'SPT',                
                'validParams' => [
                    0 => [
                        'param' => 'var',
                        'bind' => ':variabile',
                        'type' => 'int',
                        'null' => false,
                        'check' => [
                            'type' => 'integer',
                            'params' => []
                        ],
                        'value' => '82025'
                    ],
                    1 => [
                        'param' => 'type',
                        'bind' => ':tipoDato',
                        'type' => 'int',
                        'null' => false,
                        'check' => [
                            'type' => 'enum',
                            'params' => [
                                0 => [
                                    0 => 1,
                                    1 => 2
                                ]
                            ]
                        ],
                        'value' => '2'
                    ],
                    2 => [
                        'param' => 'datefrom',
                        'bind' => ':dataIniziale',
                        'type' => 'str',
                        'null' => false,
                        'check' => [
                            'type' => 'dateTime',
                            'params' => [
                                0 => true
                            ]
                        ],
                        'value' => '28/10/2018T01:00:00'
                    ],
                    3 => [
                        'param' => 'dateto',
                        'bind' => ':dataFinale',
                        'type' => 'str',
                        'null' => false,
                        'check' => [
                            'type' => 'dateTime',
                            'params' => [
                                0 => true
                            ]
                        ],
                        'value' => '28/10/2018T01:30:00'
                    ]
                ],
                'expecteds' => [
                    0 => [
                        'param' => 'var',
                        'bind' => ':variabile',
                        'type' => 'int',
                        'null' => false,
                        'check' => [
                            'type' => 'integer',
                            'params' => []
                        ],
                        'value' => '82025'
                    ],
                    1 => [
                        'param' => 'type',
                        'bind' => ':tipoDato',
                        'type' => 'int',
                        'null' => false,
                        'check' => [
                            'type' => 'enum',
                            'params' => [
                                0 => [
                                    0 => 1,
                                    1 => 2
                                ]
                            ]
                        ],
                        'value' => '2'
                    ],
                    2 => [
                        'param' => 'datefrom',
                        'bind' => ':dataIniziale',
                        'type' => 'str',
                        'null' => false,
                        'check' => [
                            'type' => 'dateTime',
                            'params' => [
                                0 => true
                            ]
                        ],
                        'value' => '2018-10-28 00:00:00'
                    ],
                    3 => [
                        'param' => 'dateto',
                        'bind' => ':dataFinale',
                        'type' => 'str',
                        'null' => false,
                        'check' => [
                            'type' => 'dateTime',
                            'params' => [
                                0 => true
                            ]
                        ],
                        'value' => '2018-10-28 00:30:00'
                    ]
                ]
            ],
            'sscp' => [
                'dbName' => 'SSCP_data',                
                'validParams' => [
                    0 => [
                        'param' => 'var',
                        'bind' => ':variabile',
                        'type' => 'int',
                        'null' => false,
                        'check' => [
                            'type' => 'integer',
                            'params' => []
                        ],
                        'value' => '82025'
                    ],
                    1 => [
                        'param' => 'type',
                        'bind' => ':tipoDato',
                        'type' => 'int',
                        'null' => false,
                        'check' => [
                            'type' => 'enum',
                            'params' => [
                                0 => [
                                    0 => 1,
                                    1 => 2
                                ]
                            ]
                        ],
                        'value' => '2'
                    ],
                    2 => [
                        'param' => 'datefrom',
                        'bind' => ':dataIniziale',
                        'type' => 'str',
                        'null' => false,
                        'check' => [
                            'type' => 'dateTime',
                            'params' => [
                                0 => true
                            ]
                        ],
                        'value' => '28/10/2018T01:00:00'
                    ],
                    3 => [
                        'param' => 'dateto',
                        'bind' => ':dataFinale',
                        'type' => 'str',
                        'null' => false,
                        'check' => [
                            'type' => 'dateTime',
                            'params' => [
                                0 => true
                            ]
                        ],
                        'value' => '28/10/2018T01:30:00'
                    ]
                ],
                'expecteds' => [
                    0 => [
                        'param' => 'var',
                        'bind' => ':variabile',
                        'type' => 'int',
                        'null' => false,
                        'check' => [
                            'type' => 'integer',
                            'params' => []
                        ],
                        'value' => '82025'
                    ],
                    1 => [
                        'param' => 'type',
                        'bind' => ':tipoDato',
                        'type' => 'int',
                        'null' => false,
                        'check' => [
                            'type' => 'enum',
                            'params' => [
                                0 => [
                                    0 => 1,
                                    1 => 2
                                ]
                            ]
                        ],
                        'value' => '2'
                    ],
                    2 => [
                        'param' => 'datefrom',
                        'bind' => ':dataIniziale',
                        'type' => 'str',
                        'null' => false,
                        'check' => [
                            'type' => 'dateTime',
                            'params' => [
                                0 => true
                            ]
                        ],
                        'value' => '2018-10-28 01:00:00'
                    ],
                    3 => [
                        'param' => 'dateto',
                        'bind' => ':dataFinale',
                        'type' => 'str',
                        'null' => false,
                        'check' => [
                            'type' => 'dateTime',
                            'params' => [
                                0 => true
                            ]
                        ],
                        'value' => '2018-10-28 01:30:00'
                    ]
                ]
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group dbWrapper
     * @covers \vaniacarta74\Crud\DbWrapper::setDateTimeParams
     * @dataProvider setDateTimeParamsProvider
     */
    public function testSetDateTimeParamsEquals($dbName, $validParams, $expected)
    {
        $actual = DbWrapper::setDateTimeParams($dbName, $validParams);
        
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * @group dbWrapper
     * @coversNothing
     */
    public function setDateTimeParamsExceptionProvider()
    {
        $data = [
            'wrong array check' => [
                'dbname' => 'SPT',
                'params' => [
                    0 => [
                        'param' => 'id',
                        'bind' => ':id_dato',
                        'type' => 'int',
                        'null' => false,
                        'pippo' => [
                            'type' => 'integer',
                            'params' => []
                        ],
                        'value' => '97047202'
                    ]
                ]
            ],
            'wrong array type' => [
                'dbname' => 'SPT',
                'params' => [
                    0 => [
                        'param' => 'id',
                        'bind' => ':id_dato',
                        'type' => 'int',
                        'null' => false,
                        'check' => [
                            'pippo' => 'integer',
                            'params' => []
                        ],
                        'value' => '97047202'
                    ]
                ]
            ],
            'no string' => [
                'dbname' => [],
                'params' => []
            ],
            'no array params' => [
                'dbname' => 'SPT',
                'params' => 'pippo'
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group dbWrapper
     * @covers \vaniacarta74\Crud\DbWrapper::setDateTimeParams
     * @dataProvider setDateTimeParamsExceptionProvider
     */
    public function testSetDateTimeParamsException($dbName, $validParams)
    {
        $this->setExpectedException('Exception');
        
        DbWrapper::setDateTimeParams($dbName, $validParams);
    }
    
    /**
     * @group dbWrapper
     * @coversNothing
     */
    public function setDateTimeProvider()
    {
        $data = [
            'zoned from local' => [
                'format' => 'Y-m-d H:i:s',                
                'oldDateTime' => '28/10/2018T01:00:00',
                'isTimeZoned' => true,
                'timeZoneIn' => 'Europe/Rome',
                'timeZoneOut' => 'Etc/GMT-1',
                'expecteds' => '2018-10-28 00:00:00'
            ],
            'zoned to local' => [
                'format' => 'Y-m-d H:i:s',                
                'oldDateTime' => '28/10/2018T01:00:00',
                'isTimeZoned' => true,
                'timeZoneIn' => 'Etc/GMT-1',
                'timeZoneOut' => 'Europe/Rome',
                'expecteds' => '2018-10-28 02:00:00'
            ],
            'no zoned' => [
                'format' => 'Y-m-d H:i:s',                
                'oldDateTime' => '28/10/2018T01:00:00',
                'isTimeZoned' => false,
                'timeZoneIn' => 'Europe/Rome',
                'timeZoneOut' => 'Etc/GMT-1',
                'expecteds' => '2018-10-28 01:00:00'
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group dbWrapper
     * @covers \vaniacarta74\Crud\DbWrapper::setDateTime
     * @dataProvider setDateTimeProvider
     */
    public function testSetDateTimeEquals($format, $oldDateTime, $isTimeZoned, $timeZoneIn, $timeZoneOut, $expected)
    {
        $actual = DbWrapper::setDateTime($format, $oldDateTime, $isTimeZoned, $timeZoneIn, $timeZoneOut);
        
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * @group dbWrapper
     * @coversNothing
     */
    public function setDateTimeExceptionProvider()
    {
        $data = [
            'no string format' => [
                'format' => [],                
                'oldDateTime' => '28/10/2018T01:00:00',
                'isTimeZoned' => true,
                'timeZoneIn' => 'Europe/Rome',
                'timeZoneOut' => 'Etc/GMT-1'
            ],
            'no string date' => [
                'format' => 'Y-m-d H:i:s',                
                'oldDateTime' => [],
                'isTimeZoned' => true,
                'timeZoneIn' => 'Europe/Rome',
                'timeZoneOut' => 'Etc/GMT-1'
            ],
            'no bool' => [
                'format' => 'Y-m-d H:i:s',                
                'oldDateTime' => '28/10/2018T01:00:00',
                'isTimeZoned' => 'pippo',
                'timeZoneIn' => 'Europe/Rome',
                'timeZoneOut' => 'Etc/GMT-1'
            ],
            'no string in' => [
                'format' => 'Y-m-d H:i:s',                
                'oldDateTime' => '28/10/2018T01:00:00',
                'isTimeZoned' => true,
                'timeZoneIn' => [],
                'timeZoneOut' => 'Etc/GMT-1'
            ],
            'no string out' => [
                'format' => 'Y-m-d H:i:s',                
                'oldDateTime' => '28/10/2018T01:00:00',
                'isTimeZoned' => true,
                'timeZoneIn' => 'Etc/GMT-1',
                'timeZoneOut' => []
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group dbWrapper
     * @covers \vaniacarta74\Crud\DbWrapper::setDateTime
     * @dataProvider setDateTimeExceptionProvider
     */
    public function testSetDateTimeException($format, $oldDateTime, $isTimeZoned, $timeZoneIn, $timeZoneOut)
    {
        $this->setExpectedException('Exception');
        
        DbWrapper::setDateTime($format, $oldDateTime, $isTimeZoned, $timeZoneIn, $timeZoneOut);
    }
    
    /**
     * @group dbWrapper
     * @coversNothing
     */
    public function formatDateTimeProvider()
    {
        $data = [
            'standard latin' => [
                'oldDateTime' => '28/10/2018T01:00:00',
                'expecteds' => [
                    'format' => 'd/m/Y H:i:s',
                    'value' => '28/10/2018 01:00:00'
                ]
            ],
            'standard anglo' => [
                'oldDateTime' => '2018-10-28T01:00:00',
                'expecteds' => [
                    'format' => 'Y-m-d H:i:s',
                    'value' => '2018-10-28 01:00:00'
                ]
            ],
            'no time latin' => [
                'oldDateTime' => '28/10/2018',
                'expecteds' => [
                    'format' => 'd/m/Y H:i:s',
                    'value' => '28/10/2018 00:00:00'
                ]
            ],
            'no time anglo' => [
                'oldDateTime' => '2018-10-28',
                'expecteds' => [
                    'format' => 'Y-m-d H:i:s',
                    'value' => '2018-10-28 00:00:00'
                ]
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group dbWrapper
     * @covers \vaniacarta74\Crud\DbWrapper::formatDateTime
     * @dataProvider formatDateTimeProvider
     */
    public function testFormatDateTimeEquals($oldDateTime, $expected)
    {
        $actual = DbWrapper::formatDateTime($oldDateTime);
        
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * @group dbWrapper
     * @coversNothing
     */
    public function formatDateTimeExceptionProvider()
    {
        $data = [
            'no string date' => [
                'oldDateTime' => []
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group dbWrapper
     * @covers \vaniacarta74\Crud\DbWrapper::formatDateTime
     * @dataProvider formatDateTimeExceptionProvider
     */
    public function testFormatDateTimeException($oldDateTime)
    {
        $this->setExpectedException('Exception');
        
        DbWrapper::formatDateTime($oldDateTime);
    }
    
    /**
     * @group dbWrapper
     * @coversNothing
     */
    public function getDateTimeFormatProvider()
    {
        $data = [
            'standard latin' => [
                'oldDateTime' => '28/10/2018T01:00:00',
                'expecteds' => 'd/m/Y H:i:s'
            ],
            'standard anglo' => [
                'oldDateTime' => '2018-10-28T01:00:00',
                'expecteds' => 'Y-m-d H:i:s'
            ],
            'no time latin' => [
                'oldDateTime' => '28/10/2018',
                'expecteds' => 'd/m/Y'
            ],
            'no time anglo' => [
                'oldDateTime' => '2018-10-28',
                'expecteds' => 'Y-m-d'
            ]
            
        ];
        
        return $data;
    }
    
    /**
     * @group dbWrapper
     * @covers \vaniacarta74\Crud\DbWrapper::getDateTimeFormat
     * @dataProvider getDateTimeFormatProvider
     */
    public function testGetDateTimeFormatEquals($oldDateTime, $expected)
    {
        $actual = DbWrapper::getDateTimeFormat($oldDateTime);
        
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * @group dbWrapper
     * @coversNothing
     */
    public function getDateTimeFormatExceptionProvider()
    {
        $data = [
            'no string date' => [
                'oldDateTime' => []
            ],
            'no converible' => [
                'oldDateTime' => '28/10/2018T00:00'
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group dbWrapper
     * @covers \vaniacarta74\Crud\DbWrapper::getDateTimeFormat
     * @dataProvider getDateTimeFormatExceptionProvider
     */
    public function testGetDateTimeFormatException($oldDateTime)
    {
        $this->setExpectedException('Exception');
        
        DbWrapper::getDateTimeFormat($oldDateTime);
    }
    
    /**
     * @group dbWrapper
     * @coversNothing
     */
    public function setDateTimeResultsProvider()
    {
        $data = [
            'all' => [
                'dbName' => 'dbcore',
                'purgedQuery' => [
                    'fields' => [
                        0 => [
                            'name' => 'COUNT(*)',
                            'alias' => 'n_record',
                            'type' => 'integer'
                        ]
                    ],
                    'table' => 'variabili_sync',
                    'where' => [],
                    'order' => [],
                    'type' => 'all'
                ],
                'results' => [                    
                    'type' => 'all',
                    'records' => [
                        0 => [
                            'n_record' => '44'
                        ]
                    ],
                    'id' => null                    
                ],
                'expecteds' => [                    
                    'type' => 'all',
                    'records' => [
                        0 => [
                            'n_record' => '44'
                        ]
                    ],
                    'id' => null                    
                ]    
            ],
            'read' => [
                'dbName' => 'SPT',
                'purgedQuery' => [
                    'fields' => [
                        0 => [
                            'name' => 'id_dato',
                            'alias' => 'id',
                            'type' => 'integer'
                        ],
                        1 => [
                            'name' => 'variabile',
                            'alias' => null,
                            'type' => 'integer'
                        ],
                        2 => [
                            'name' => 'valore',
                            'alias' => null,
                            'type' => 'float'
                        ],
                        3 => [
                            'name' => 'CONVERT(varchar, data_e_ora, 20)',
                            'alias' => 'data_e_ora',
                            'type' => 'dateTime'
                        ],
                        4 => [
                            'name' => 'tipo_dato',
                            'alias' => null,
                            'type' => 'integer'
                        ]
                    ],
                    'table' => 'dati_acquisiti',
                    'where' => [
                        'and' => [
                            0 => [
                                'field' => 'id_dato',
                                'operator' => '=',
                                'value' => [
                                    'param' => 'id',
                                    'bind' => ':id_dato',
                                    'type' => 'int',
                                    'null' => false,
                                    'check' => [
                                        'type' => 'integer',
                                        'params' => []
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'order' => [],
                    'type' => 'read'
                ],
                'results' => [                    
                    'type' => 'read',
                    'records' => [
                        0 => [
                            'id' => '97047202',
                            'variabile' => '82025',
                            'valore' => '0',
                            'data_e_ora' => '28/10/2018 00:00:00',
                            'tipo_dato' => '2'
                        ]
                    ],
                    'id' => '97047202'                    
                ],
                'expecteds' => [                    
                    'type' => 'read',
                    'records' => [
                        0 => [
                            'id' => '97047202',
                            'variabile' => '82025',
                            'valore' => '0',
                            'data_e_ora' => '28/10/2018 01:00:00',
                            'tipo_dato' => '2'
                        ]
                    ],
                    'id' => '97047202'                    
                ]    
            ],
            'list' => [
                'dbName' => 'SPT',                
                'purgedQuery' => [
                    'fields' => [
                        0 => [
                            'name' => 'id_dato',
                            'alias' => 'id',
                            'type' => 'integer'
                        ],
                        1 => [
                            'name' => 'variabile',
                            'alias' => null,
                            'type' => 'integer'
                        ],
                        2 => [
                            'name' => 'valore',
                            'alias' => null,
                            'type' => 'float'
                        ],
                        3 => [
                            'name' => 'CONVERT(varchar, data_e_ora, 20)',
                            'alias' => 'data_e_ora',
                            'type' => 'dateTime'
                        ],
                        4 => [
                            'name' => 'tipo_dato',
                            'alias' => null,
                            'type' => 'integer'
                        ]
                    ],
                    'table' => 'dati_acquisiti',
                    'where' => [
                        'and' => [
                            0 => [
                                'field' => 'variabile',
                                'operator' => '=',
                                'value' => [
                                    'param' => 'var',
                                    'bind' => ':variabile',
                                    'type' => 'int',
                                    'null' => false,
                                    'check' => [
                                        'type' => 'integer',
                                        'params' => []
                                    ]
                                ]
                            ],
                            1 => [
                                'field' => 'tipo_dato',
                                'operator' => '=',
                                'value' => [
                                    'param' => 'type',
                                    'bind' => ':tipoDato',
                                    'type' => 'int',
                                    'null' => false,
                                    'check' => [
                                        'type' => 'enum',
                                        'params' => [
                                            0 => [
                                                0 => 1,
                                                1 => 2
                                            ]
                                        ]
                                    ]
                                ]
                            ],
                            2 => [
                                'field' => 'data_e_ora',
                                'operator' => '>=',
                                'value' => [
                                    'param' => 'datefrom',
                                    'bind' => ':dataIniziale',
                                    'type' => 'str',
                                    'null' => false,
                                    'check' => [
                                        'type' => 'dateTime',
                                        'params' => [
                                            0 => true
                                        ]
                                    ]
                                ]
                            ],
                            3 => [
                                'field' => 'data_e_ora',
                                'operator' => '<',
                                'value' => [
                                    'param' => 'dateto',
                                    'bind' => ':dataFinale',
                                    'type' => 'str',
                                    'null' => false,
                                    'check' => [
                                        'type' => 'dateTime',
                                        'params' => [
                                            0 => true
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'order' => [
                        0 => [
                            'field' => 'data_e_ora',
                            'type' => 'asc'
                        ]
                    ],
                    'type' => 'list'
                ],
                'results' => [
                    'type' => 'list',
                    'records' => [
                        0 => [
                            'id' => '97047200',
                            'variabile' => '82025',
                            'valore' => '0',
                            'data_e_ora' => '28/10/2018 01:00:00',
                            'tipo_dato' => '2'
                        ]
                    ],
                    'id' => null
                ],
                'expected' => [
                    'type' => 'list',
                    'records' => [
                        0 => [
                            'id' => '97047200',
                            'variabile' => '82025',
                            'valore' => '0',
                            'data_e_ora' => '28/10/2018 02:00:00',
                            'tipo_dato' => '2'
                        ]
                    ],
                    'id' => null
                ]    
            ],
            'create' => [
                'dbname' => 'SPT',
                'purgedQuery' => [                        
                    'table' => 'dati_acquisiti',
                    'type' => 'create',
                    'values' => [
                        0 => [
                            'field' => 'variabile',
                            'value' => [
                                'param' => 'var',
                                'bind' => ':variabile',
                                'type' => 'int',
                                'null' => false,
                                'check' => [
                                    'type' => 'integer',
                                    'params' => []
                                ]
                            ]
                        ],
                        1 => [
                            'field' => 'tipo_dato',
                            'value' => [
                                'param' => 'type',
                                'bind' => ':tipoDato',
                                'type' => 'int',
                                'null' => false,
                                'check' => [
                                    'type' => 'enum',
                                    'params' => [
                                        0 => [
                                            0 => 1,
                                            1 => 2
                                        ]
                                    ]
                                ]
                            ]
                        ],
                        2 => [
                            'field' => 'data_e_ora',
                            'value' => [
                                'param' => 'date',
                                'bind' => ':data_e_ora',
                                'type' => 'str',
                                'null' => false,
                                'check' => [
                                    'type' => 'dateTime',
                                    'params' => [
                                        0 => true
                                    ]
                                ]
                            ]
                        ],
                        3 => [
                            'field' => 'valore',
                            'value' => [
                                'param' => 'val',
                                'bind' => ':valore',
                                'type' => 'int',
                                'null' => false,
                                'check' => [
                                    'type' => 'float',
                                    'params' => []
                                ]
                            ]
                        ]
                    ]
                ],
                'results' => [
                    'type' => 'create',                    
                    'id' => '999999999'
                ],
                'expecteds' => [
                    'type' => 'create',                    
                    'id' => '999999999'
                ]
            ],
            'update' => [
                'dbName' => 'SPT',
                'purgedQuery' => [                        
                    'table' => 'dati_acquisiti',
                    'type' => 'update',
                    'set' => [                            
                        2 => [
                            'field' => 'data_e_ora',
                            'value' => [
                                'param' => 'date',
                                'bind' => ':data_e_ora',
                                'type' => 'str',
                                'null' => true,
                                'check' => [
                                    'type' => 'dateTime',
                                    'params' => [
                                        0 => true
                                    ]
                                ]
                            ]
                        ],
                        3 => [
                            'field' => 'valore',
                            'value' => [
                                'param' => 'val',
                                'bind' => ':valore',
                                'type' => 'int',
                                'null' => true,
                                'check' => [
                                    'type' => 'float',
                                    'params' => []
                                ]
                            ]
                        ]
                    ],
                    'where' => [
                        'and' => [
                            0 => [
                                'field' => 'id_dato',
                                'operator' => '=',
                                'value' => [
                                    'param' => 'id',
                                    'bind' => ':id_dato',
                                    'type' => 'int',
                                    'null' => false,
                                    'check' => [
                                        'type' => 'integer',
                                        'params' => []
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                'results' => [
                    'type' => 'update',
                    'id' => '101540010'
                ],
                'expecteds' => [
                    'type' => 'update',
                    'id' => '101540010'
                ]
            ],
            'delete' => [
                'dbName' => 'SPT',
                'purgedQuery' => [                        
                    'table' => 'dati_acquisiti',
                    'type' => 'delete',
                    'where' => [
                        'and' => [
                            0 => [
                                'field' => 'id_dato',
                                'operator' => '=',
                                'value' => [
                                    'param' => 'id',
                                    'bind' => ':id_dato',
                                    'type' => 'int',
                                    'null' => false,
                                    'check' => [
                                        'type' => 'integer',
                                        'params' => []
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                'results' => [
                    'type' => 'delete',
                    'id' => '999999999'
                ],
                'expecteds' => [
                    'type' => 'delete',
                    'id' => '999999999'
                ]
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group dbWrapper
     * @covers \vaniacarta74\Crud\DbWrapper::setDateTimeResults
     * @dataProvider setDateTimeResultsProvider
     */
    public function testSetDateTimeResultsEquals($dbName, $purgedQuery, $results, $expected)
    {
        $actual = DbWrapper::setDateTimeResults($dbName, $purgedQuery, $results);
        
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * @group dbWrapper
     * @coversNothing
     */
    public function setDateTimeResultsExceptionProvider()
    {
        $data = [
            'no string' => [
                'dbname' => [],
                'query' => [],
                'params' => []
            ],
            'no array query' => [
                'dbname' => 'SPT',
                'query' => 'pippo',
                'params' => []
            ],
            'no array results' => [
                'dbname' => 'SPT',
                'query' => [],
                'params' => 'pippo'
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group dbWrapper
     * @covers \vaniacarta74\Crud\DbWrapper::setDateTimeResults
     * @dataProvider setDateTimeResultsExceptionProvider
     */
    public function testSetDateTimeResultsException($dbName, $purgedQuery, $results)
    {
        $this->setExpectedException('Exception');
        
        DbWrapper::setDateTimeResults($dbName, $purgedQuery, $results);
    }
    
    /**
     * @group dbWrapper
     * @coversNothing
     */
    public function getDateTimeFieldsProvider()
    {
        $data = [
            'read' => [
                'purgedQuery' => [
                    'fields' => [],
                    'table' => 'variabili_sync',
                    'where' => [],
                    'order' => [],
                    'type' => 'all'
                ],
                'expecteds' => []    
            ],
            'read' => [
                'purgedQuery' => [
                    'fields' => [
                        0 => [
                            'name' => 'id_dato',
                            'alias' => 'id',
                            'type' => 'integer'
                        ],
                        1 => [
                            'name' => 'variabile',
                            'alias' => null,
                            'type' => 'integer'
                        ],
                        2 => [
                            'name' => 'valore',
                            'alias' => null,
                            'type' => 'float'
                        ],
                        3 => [
                            'name' => 'CONVERT(varchar, data_e_ora, 20)',
                            'alias' => 'data_e_ora',
                            'type' => 'dateTime'
                        ],
                        4 => [
                            'name' => 'tipo_dato',
                            'alias' => null,
                            'type' => 'integer'
                        ]
                    ],
                    'table' => 'dati_acquisiti',
                    'where' => [
                        'and' => [
                            0 => [
                                'field' => 'id_dato',
                                'operator' => '=',
                                'value' => [
                                    'param' => 'id',
                                    'bind' => ':id_dato',
                                    'type' => 'int',
                                    'null' => false,
                                    'check' => [
                                        'type' => 'integer',
                                        'params' => []
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'order' => [],
                    'type' => 'read'
                ],
                'expecteds' => [                    
                    0 => 'data_e_ora'                    
                ]    
            ],
            'list' => [
                'purgedQuery' => [
                    'fields' => [
                        0 => [
                            'name' => 'id_dato',
                            'alias' => 'id',
                            'type' => 'integer'
                        ],
                        1 => [
                            'name' => 'variabile',
                            'alias' => null,
                            'type' => 'integer'
                        ],
                        2 => [
                            'name' => 'valore',
                            'alias' => null,
                            'type' => 'float'
                        ],
                        3 => [
                            'name' => 'CONVERT(varchar, data_e_ora, 20)',
                            'alias' => 'data_e_ora',
                            'type' => 'dateTime'
                        ],
                        4 => [
                            'name' => 'tipo_dato',
                            'alias' => null,
                            'type' => 'integer'
                        ]
                    ],
                    'table' => 'dati_acquisiti',
                    'where' => [
                        'and' => [
                            0 => [
                                'field' => 'variabile',
                                'operator' => '=',
                                'value' => [
                                    'param' => 'var',
                                    'bind' => ':variabile',
                                    'type' => 'int',
                                    'null' => false,
                                    'check' => [
                                        'type' => 'integer',
                                        'params' => []
                                    ]
                                ]
                            ],
                            1 => [
                                'field' => 'tipo_dato',
                                'operator' => '=',
                                'value' => [
                                    'param' => 'type',
                                    'bind' => ':tipoDato',
                                    'type' => 'int',
                                    'null' => false,
                                    'check' => [
                                        'type' => 'enum',
                                        'params' => [
                                            0 => [
                                                0 => 1,
                                                1 => 2
                                            ]
                                        ]
                                    ]
                                ]
                            ],
                            2 => [
                                'field' => 'data_e_ora',
                                'operator' => '>=',
                                'value' => [
                                    'param' => 'datefrom',
                                    'bind' => ':dataIniziale',
                                    'type' => 'str',
                                    'null' => false,
                                    'check' => [
                                        'type' => 'dateTime',
                                        'params' => [
                                            0 => true
                                        ]
                                    ]
                                ]
                            ],
                            3 => [
                                'field' => 'data_e_ora',
                                'operator' => '<',
                                'value' => [
                                    'param' => 'dateto',
                                    'bind' => ':dataFinale',
                                    'type' => 'str',
                                    'null' => false,
                                    'check' => [
                                        'type' => 'dateTime',
                                        'params' => [
                                            0 => true
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'order' => [
                        0 => [
                            'field' => 'data_e_ora',
                            'type' => 'asc'
                        ]
                    ],
                    'type' => 'list'
                ],
                'expected' => [
                    0 => 'data_e_ora'
                ]    
            ],
            'create' => [
                'purgedQuery' => [                        
                    'table' => 'dati_acquisiti',
                    'type' => 'create',
                    'values' => [
                        0 => [
                            'field' => 'variabile',
                            'value' => [
                                'param' => 'var',
                                'bind' => ':variabile',
                                'type' => 'int',
                                'null' => false,
                                'check' => [
                                    'type' => 'integer',
                                    'params' => []
                                ]
                            ]
                        ],
                        1 => [
                            'field' => 'tipo_dato',
                            'value' => [
                                'param' => 'type',
                                'bind' => ':tipoDato',
                                'type' => 'int',
                                'null' => false,
                                'check' => [
                                    'type' => 'enum',
                                    'params' => [
                                        0 => [
                                            0 => 1,
                                            1 => 2
                                        ]
                                    ]
                                ]
                            ]
                        ],
                        2 => [
                            'field' => 'data_e_ora',
                            'value' => [
                                'param' => 'date',
                                'bind' => ':data_e_ora',
                                'type' => 'str',
                                'null' => false,
                                'check' => [
                                    'type' => 'dateTime',
                                    'params' => [
                                        0 => true
                                    ]
                                ]
                            ]
                        ],
                        3 => [
                            'field' => 'valore',
                            'value' => [
                                'param' => 'val',
                                'bind' => ':valore',
                                'type' => 'int',
                                'null' => false,
                                'check' => [
                                    'type' => 'float',
                                    'params' => []
                                ]
                            ]
                        ]
                    ]
                ],
                'expecteds' => []
            ],
            'update' => [
                'purgedQuery' => [                        
                    'table' => 'dati_acquisiti',
                    'type' => 'update',
                    'set' => [                            
                        2 => [
                            'field' => 'data_e_ora',
                            'value' => [
                                'param' => 'date',
                                'bind' => ':data_e_ora',
                                'type' => 'str',
                                'null' => true,
                                'check' => [
                                    'type' => 'dateTime',
                                    'params' => [
                                        0 => true
                                    ]
                                ]
                            ]
                        ],
                        3 => [
                            'field' => 'valore',
                            'value' => [
                                'param' => 'val',
                                'bind' => ':valore',
                                'type' => 'int',
                                'null' => true,
                                'check' => [
                                    'type' => 'float',
                                    'params' => []
                                ]
                            ]
                        ]
                    ],
                    'where' => [
                        'and' => [
                            0 => [
                                'field' => 'id_dato',
                                'operator' => '=',
                                'value' => [
                                    'param' => 'id',
                                    'bind' => ':id_dato',
                                    'type' => 'int',
                                    'null' => false,
                                    'check' => [
                                        'type' => 'integer',
                                        'params' => []
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                'expecteds' => []
            ],
            'delete' => [
                'purgedQuery' => [                        
                    'table' => 'dati_acquisiti',
                    'type' => 'delete',
                    'where' => [
                        'and' => [
                            0 => [
                                'field' => 'id_dato',
                                'operator' => '=',
                                'value' => [
                                    'param' => 'id',
                                    'bind' => ':id_dato',
                                    'type' => 'int',
                                    'null' => false,
                                    'check' => [
                                        'type' => 'integer',
                                        'params' => []
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                'expecteds' => []
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group dbWrapper
     * @covers \vaniacarta74\Crud\DbWrapper::getDateTimeFields
     * @dataProvider getDateTimeFieldsProvider
     */
    public function testGetDateTimeFieldsEquals($purgedQuery, $expected)
    {
        $actual = DbWrapper::getDateTimeFields($purgedQuery);
        
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * @group dbWrapper
     * @coversNothing
     */
    public function getDateTimeFieldsExceptionProvider()
    {
        $data = [
            'no array query' => [
                'query' => 'pippo'
            ],
            'wrong array type' => [
                'query' => []
            ],
            'wrong array fields' => [
                'query' => [
                    'type' => 'list'
                ]
            ],
            'wrong array fields type' => [
                'query' => [
                    'fields' => [
                        0 => []
                    ],
                    'type' => 'list'
                ]
            ],
            'wrong array fields type alias' => [
                'query' => [
                    'fields' => [
                        0 => [
                            'name' => 'pippo',
                            'type' => 'dateTime'
                        ]
                    ],
                    'type' => 'list'
                ]
            ],
            'wrong array fields type name' => [
                'query' => [
                    'fields' => [
                        0 => [
                            'alias' => 'pippo',
                            'type' => 'dateTime'
                        ]
                    ],
                    'type' => 'list'
                ]
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group dbWrapper
     * @covers \vaniacarta74\Crud\DbWrapper::getDateTimeFields
     * @dataProvider getDateTimeFieldsExceptionProvider
     */
    public function testGetDateTimeFieldsException($purgedQuery)
    {
        $this->setExpectedException('Exception');
        
        DbWrapper::getDateTimeFields($purgedQuery);
    }
    
    /**
     * @group dbWrapper
     * @coversNothing
     */
    public function changeDateTimeResultsProvider()
    {
        $data = [
            'all zoned' => [
                'dateTimeFields' => [
                    0 => 'data_e_ora'
                ],
                'results' => [                    
                    'type' => 'all',
                    'records' => [
                        0 => [
                            'variabile' => '82025',
                            'valore' => '0',
                            'data_e_ora' => '28/10/2018 00:00:00',
                            'tipo_dato' => '2'
                        ]
                    ],
                    'id' => null                  
                ],
                'isTimeZoned' => true,
                'expecteds' => [                    
                    'type' => 'all',
                    'records' => [
                        0 => [
                            'variabile' => '82025',
                            'valore' => '0',
                            'data_e_ora' => '28/10/2018 01:00:00',
                            'tipo_dato' => '2'
                        ]
                    ],
                    'id' => null                    
                ]    
            ],
            'read zoned' => [
                'dateTimeFields' => [
                    0 => 'data_e_ora'
                ],
                'results' => [                    
                    'type' => 'read',
                    'records' => [
                        0 => [
                            'id' => '97047202',
                            'variabile' => '82025',
                            'valore' => '0',
                            'data_e_ora' => '28/10/2018 00:00:00',
                            'tipo_dato' => '2'
                        ]
                    ],
                    'id' => '97047202'                    
                ],
                'isTimeZoned' => true,
                'expecteds' => [                    
                    'type' => 'read',
                    'records' => [
                        0 => [
                            'id' => '97047202',
                            'variabile' => '82025',
                            'valore' => '0',
                            'data_e_ora' => '28/10/2018 01:00:00',
                            'tipo_dato' => '2'
                        ]
                    ],
                    'id' => '97047202'                    
                ]    
            ],
            'read not zoned' => [
                'dateTimeFields' => [
                    0 => 'data_e_ora'
                ],
                'results' => [                    
                    'type' => 'read',
                    'records' => [
                        0 => [
                            'id' => '97047202',
                            'variabile' => '82025',
                            'valore' => '0',
                            'data_e_ora' => '28/10/2018 00:00:00',
                            'tipo_dato' => '2'
                        ]
                    ],
                    'id' => '97047202'                    
                ],
                'isTimeZoned' => false,
                'expecteds' => [                    
                    'type' => 'read',
                    'records' => [
                        0 => [
                            'id' => '97047202',
                            'variabile' => '82025',
                            'valore' => '0',
                            'data_e_ora' => '28/10/2018 00:00:00',
                            'tipo_dato' => '2'
                        ]
                    ],
                    'id' => '97047202'                    
                ]    
            ],
            'list zoned' => [
                'dateTimeFields' => [
                    0 => 'data_e_ora'
                ],
                'results' => [
                    'type' => 'list',
                    'records' => [
                        0 => [
                            'id' => '97047200',
                            'variabile' => '82025',
                            'valore' => '0',
                            'data_e_ora' => '28/10/2018 01:00:00',
                            'tipo_dato' => '2'
                        ]
                    ],
                    'id' => null
                ],
                'isTimeZoned' => true,
                'expected' => [
                    'type' => 'list',
                    'records' => [
                        0 => [
                            'id' => '97047200',
                            'variabile' => '82025',
                            'valore' => '0',
                            'data_e_ora' => '28/10/2018 02:00:00',
                            'tipo_dato' => '2'
                        ]
                    ],
                    'id' => null
                ]    
            ],
            'list not zoned' => [
                'dateTimeFields' => [
                    0 => 'data_e_ora'
                ],
                'results' => [
                    'type' => 'list',
                    'records' => [
                        0 => [
                            'id' => '97047200',
                            'variabile' => '82025',
                            'valore' => '0',
                            'data_e_ora' => '28/10/2018 01:00:00',
                            'tipo_dato' => '2'
                        ]
                    ],
                    'id' => null
                ],
                'isTimeZoned' => false,
                'expected' => [
                    'type' => 'list',
                    'records' => [
                        0 => [
                            'id' => '97047200',
                            'variabile' => '82025',
                            'valore' => '0',
                            'data_e_ora' => '28/10/2018 01:00:00',
                            'tipo_dato' => '2'
                        ]
                    ],
                    'id' => null
                ]    
            ],
            'create' => [
                'dateTimeFields' => [],
                'results' => [
                    'type' => 'create',
                    'records' => [],
                    'id' => '999999999'
                ],
                'isTimeZoned' => true,
                'expecteds' => [
                    'type' => 'create',                    
                    'id' => '999999999'
                ]
            ],
            'update' => [
                'dateTimeFields' => [],
                'results' => [
                    'type' => 'update',
                    'records' => [],                    
                    'id' => '101540010'
                ],
                'isTimeZoned' => true,
                'expecteds' => [
                    'type' => 'update',
                    'id' => '101540010'
                ]
            ],
            'delete' => [
                'dateTimeFields' => [],
                'results' => [
                    'type' => 'delete',
                    'records' => [],
                    'id' => '999999999'
                ],
                'isTimeZoned' => true,
                'expecteds' => [
                    'type' => 'delete',
                    'id' => '999999999'
                ]
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group dbWrapper
     * @covers \vaniacarta74\Crud\DbWrapper::changeDateTimeResults
     * @dataProvider changeDateTimeResultsProvider
     */
    public function testChangeDateTimeResultsEquals($dateTimeFields, $results, $isTimeZoned, $expected)
    {
        $actual = DbWrapper::changeDateTimeResults($dateTimeFields, $results, $isTimeZoned);
        
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * @group dbWrapper
     * @coversNothing
     */
    public function changeDateTimeResultsExceptionProvider()
    {
        $data = [
            'no array fields' => [
                'dateTimeFields' => 'pippo',
                'results' => [],
                'isTimeZoned' => true
            ],
            'no array results' => [
                'dateTimeFields' => [],
                'results' => 'pippo',
                'isTimeZoned' => true
            ],
            'no array zoned' => [
                'dateTimeFields' => [],
                'results' => [],
                'isTimeZoned' => 'pippo'
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group dbWrapper
     * @covers \vaniacarta74\Crud\DbWrapper::changeDateTimeResults
     * @dataProvider changeDateTimeResultsExceptionProvider
     */
    public function testChangeDateTimeResultsException($dateTimeFields, $results, $isTimeZoned)
    {
        $this->setExpectedException('Exception');
        
        DbWrapper::changeDateTimeResults($dateTimeFields, $results, $isTimeZoned);
    }
    
    /**
     * @group dbWrapper
     * @coversNothing
     */
    public function dbBuilderProvider()
    {
        $data = [
            'standard' => [
                'host' => 'h1',
                'dbName' => 'SPT',
                'driver' => 'dblib'
            ],
            'driver null' => [
                'host' => 'h1',
                'dbName' => 'SPT',
                'driver' => null
            ],
            'h2' => [
                'host' => 'h2',
                'dbName' => 'SPT',
                'driver' => 'dblib'
            ],
            'driver mssql' => [
                'host' => 'h2',
                'dbName' => 'SPT',
                'driver' => 'mssql'
            ],
            'driver sqlsrv' => [
                'host' => 'h2',
                'dbName' => 'SPT',
                'driver' => 'sqlsrv'
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group dbWrapper
     * @covers \vaniacarta74\Crud\DbWrapper::dbBuilder
     * @dataProvider dbBuilderProvider
     */
    public function testDbBuilderEquals($host, $dbName, $driver)
    {
        $actual = DbWrapper::dbBuilder($host, $dbName, $driver);
        
        $this->assertInstanceOf('\vaniacarta74\Crud\Db', $actual);
        
    }
    
    /**
     * @group dbWrapper
     * @coversNothing
     */
    public function dbBuilderExceptionProvider()
    {
        $data = [
            'no string host' => [
                'host' => [],
                'dbName' => 'SPT',
                'driver' => 'dblib'
            ],
            'no string dbName' => [
                'host' => 'h1',
                'dbName' => [],
                'driver' => 'dblib'
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group dbWrapper
     * @covers \vaniacarta74\Crud\DbWrapper::dbBuilder
     * @dataProvider dbBuilderExceptionProvider
     */
    public function testDbBuilderException($host, $dbName, $driver)
    {
        $this->setExpectedException('Exception');
        
        DbWrapper::dbBuilder($host, $dbName, $driver);
    }
}
