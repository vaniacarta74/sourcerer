<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace vaniacarta74\Crud\tests\Unit;

use PHPUnit\Framework\TestCase;
use vaniacarta74\Crud\Db;
use vaniacarta74\Crud\tests\classes\Reflections;

/**
 * Description of DbTest
 *
 * @author Vania
 */
class DbTest  extends TestCase
{
    private $db;
    
    protected function setUp()
    {
        $this->db = new Db('SPT');
    }
    
    protected function tearDown()
    {
        $this->db = null;
    }
    
    /**
     * @group db
     * @coversNothing
     */
    public function constructorProvider()
    {
        $data = [
            'standard' => [
                'args' => [
                    'db' => 'SPT',
                    'driver' => null,
                    'host' => null,
                    'user' => null,
                    'password' => null
                ],
                'expected' => [
                    'db' => 'SPT',
                    'driver' => 'dblib',
                    'host' => MSSQL_HOST,
                    'user' => MSSQL_USER,
                    'password' => MSSQL_PASSWORD,
                    'dsn' => 'dblib:host=' . MSSQL_HOST . ';dbname=SPT'
                ]
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::__construct
     * @dataProvider constructorProvider
     */
    public function testConstructorEquals($args, $expected)
    {
        Reflections::invokeConstructor($this->db, $args);
        
        $actual['db'] = Reflections::getProperty($this->db, 'db');
        $actual['driver'] = Reflections::getProperty($this->db, 'driver');
        $actual['host'] = Reflections::getProperty($this->db, 'host');
        $actual['user'] = Reflections::getProperty($this->db, 'user');
        $actual['password'] = Reflections::getProperty($this->db, 'password');
        $actual['dsn'] = Reflections::getProperty($this->db, 'dsn');
        
        $this->assertEquals($expected, $actual);         
    }
    
    /**
     * @group db
     * @coversNothing
     */
    public function constructorExceptionProvider()
    {
        $data = [
            'no string' => [
                'args' => [
                    'db' => [],
                    'driver' => null,
                    'host' => null,
                    'user' => null,
                    'password' => null
                ]
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::__construct
     * @dataProvider constructorExceptionProvider
     */
    public function testConstructorException($args)
    {
        $this->setExpectedException('Exception');
        
        Reflections::invokeConstructor($this->db, $args);
    }
    
    /**
     * @group db
     * @coversNothing
     */
    public function runProvider()
    {
        $data = [
            'all' => [
                'args' => [
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
                    'bindParams' => []
                ],
                'expected' => [                    
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
                'args' => [
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
                    'bindParams' => [
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
                'expected' => [                    
                    'type' => 'read',
                    'records' => [
                        0 => [
                            'id' => '97047202',
                            'variabile' => '82025',
                            'valore' => '0',
                            'data_e_ora' => '2018-10-28 01:00:00',
                            'tipo_dato' => '2'
                        ]
                    ],
                    'id' => '97047202'                    
                ]
            ],
            'list' => [
                'args' => [
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
                    'bindParams' => [
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
                            'value' => '2018-10-18 01:00:00'
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
                            'value' => '2018-10-18 01:30:00'
                        ]
                    ]
                ],
                'expected' => [
                    'type' => 'list',
                    'records' => [
                        0 => [
                            'id' => '96776451',
                            'variabile' => '82025',
                            'valore' => '0',
                            'data_e_ora' => '2018-10-18 01:00:00',
                            'tipo_dato' => '2'
                        ]
                    ],
                    'id' => null
                ]
            ],
            'create' => [
                'args' => [
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
                    'bindParams' => [
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
                            'value' => '2018-10-20 01:00:00'
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
                    ]
                ],
                'expected' => [
                    'type' => 'create',
                    'records' => [],
                    'id' => '@id@'
                ]
            ],
            'update' => [
                'args' => [
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
                    'bindParams' => [
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
                            'value' => '2018-10-20 01:30:00'
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
                    ]
                ],
                'expected' => [
                    'type' => 'update',
                    'records' => [],
                    'id' => '101540010'
                ]
            ],
            'delete' => [
                'args' => [
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
                    'bindParams' => [
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
                    ]
                ],
                'expected' => [
                    'type' => 'delete',
                    'records' => [],
                    'id' => '@id@'
                ]
            ]
            
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::run
     * @dataProvider runProvider
     */
    public function testRunEquals($args, $expected)
    {
        $jsonId = file_get_contents(__DIR__ . '/../providers/wrapper.json');
        $arrJson = json_decode($jsonId, true);
        $newId = $arrJson['id_dato'];
        $method = $args['purgedQuery']['type'];
        
        if ($method === 'delete') {            
            $args['bindParams'][0]['value'] = str_replace('@id@', $newId, $args['bindParams'][0]['value']);
            $expected['id'] = str_replace('@id@', $newId, $expected['id']);
        }
        
        if ($method === 'create') {            
            $expected['id'] = str_replace('@id@', $newId, $expected['id']);
        }
        
        if ($method === 'all') {
            $this->db = New Db('dbcore');
        } else {
            $this->db = New Db('SPT');
        }
        $actual = Reflections::invokeMethod($this->db, 'run', $args);
        
        $this->assertEquals($expected, $actual); 
        
        if ($method === 'delete') {            
            file_put_contents(__DIR__ . '/../providers/wrapper.json','{"id_dato":' . ($newId + 1) . '}');
        }
    }
    
    /**
     * @group db
     * @coversNothing
     */
    public function runExceptionProvider()
    {
        $data = [            
            'no array query' => [
                'args' => [
                    'query' => 'pippo',
                    'params' => []
                ]
            ],
            'no array params' => [
                'args' => [
                    'query' => [],
                    'params' => 'pippo'
                ]
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::run
     * @dataProvider runExceptionProvider
     */
    public function testRunException($args)
    {
        $this->setExpectedException('Exception');
        
        Reflections::invokeMethod($this->db, 'run', $args);
    }
    
    /**
     * @group db
     * @coversNothing
     */
    public function connectExceptionProvider()
    {
        $data = [            
            'standard' => [
                'db' => 'SPT',
                'driver' => 'dblib',
                'host' => MSSQL_HOST,
                'user' => MSSQL_USER,
                'password' => 'pippo'
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::connect
     * @dataProvider connectExceptionProvider
     */
    public function testConnectException()
    {
        Reflections::setProperty($this->db, 'db', $db);
        Reflections::setProperty($this->db, 'driver', $driver);
        Reflections::setProperty($this->db, 'host', $host);
        Reflections::setProperty($this->db, 'user', $user);
        Reflections::setProperty($this->db, 'password', $password);
        
        $this->setExpectedException('PDOException');
        
        Reflections::invokeMethod($this->db, 'connect');
    }
    
    /**
     * @group db
     * @coversNothing
     */
    public function connectProvider()
    {
        $data = [
            'dbutz' => [
                'db' => 'dbutz',
                'driver' => 'dblib',
                'host' => MSSQL_HOST,
                'user' => MSSQL_USER,
                'password' => MSSQL_PASSWORD
            ],
            'race' => [
                'db' => 'SPT',
                'driver' => 'dblib',
                'host' => 'RACE\SQL_SERVER_RACE',
                'user' => 'sa',
                'password' => 'Race14Maggio2016'
            ],
            'standard' => [
                'db' => 'SPT',
                'driver' => 'dblib',
                'host' => MSSQL_HOST,
                'user' => MSSQL_USER,
                'password' => MSSQL_PASSWORD
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::connect
     * @dataProvider connectProvider
     */
    public function testConnectIsResource($db, $driver, $host, $user, $password)
    {
        Reflections::setProperty($this->db, 'db', $db);
        Reflections::setProperty($this->db, 'driver', $driver);
        Reflections::setProperty($this->db, 'host', $host);
        Reflections::setProperty($this->db, 'user', $user);
        Reflections::setProperty($this->db, 'password', $password);
        
        Reflections::invokeMethod($this->db, 'connect');
        
        $actual = Reflections::getProperty($this->db, 'pdo');
        
        $this->assertInstanceOf('PDO', $actual);        
    }
    
    /**
     * @group db
     * @coversNothing
     */
    public function assembleProvider()
    {
        $data = [
            'all' => [
                'args' => [
                    'purgedQuery' => [
                        'fields' => [],
                        'table' => 'variabili_sync',
                        'where' => [],
                        'order' => [],
                        'type' => 'all'
                    ]
                ],
                'expected' => 'SELECT * FROM variabili_sync;'
            ],
            'read' => [
                'args' => [
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
                    ]
                ],
                'expected' => 'SELECT id_dato AS id, variabile, valore, CONVERT(varchar, data_e_ora, 20) AS data_e_ora, tipo_dato FROM dati_acquisiti WHERE (id_dato = :id_dato);'
            ],
            'list' => [
                'args' => [
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
                    ]                    
                ],
                'expected' => 'SELECT id_dato AS id, variabile, valore, CONVERT(varchar, data_e_ora, 20) AS data_e_ora, tipo_dato FROM dati_acquisiti WHERE (variabile = :variabile AND tipo_dato = :tipoDato AND data_e_ora >= :dataIniziale AND data_e_ora < :dataFinale) ORDER BY data_e_ora ASC;'
            ],
            'create' => [
                'args' => [
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
                    ]
                ],
                'expected' => 'INSERT INTO dati_acquisiti (variabile, tipo_dato, data_e_ora, valore) VALUES (:variabile, :tipoDato, :data_e_ora, :valore);'
            ],
            'update' => [
                'args' => [
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
                    ]
                ],
                'expected' => 'UPDATE dati_acquisiti SET data_e_ora = :data_e_ora, valore = :valore WHERE (id_dato = :id_dato);'
            ],
            'delete' => [
                'args' => [
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
                    ]
                ],
                'expected' => 'DELETE FROM dati_acquisiti WHERE (id_dato = :id_dato);'
            ]            
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::assemble
     * @dataProvider assembleProvider
     */
    public function testAssembleEquals($args, $expected)
    {
        Reflections::invokeMethod($this->db, 'assemble', $args);
        
        $actual = Reflections::getProperty($this->db, 'query');
        
        $this->assertEquals($expected, $actual);         
    }
    
    /**
     * @group db
     * @coversNothing
     */
    public function assembleExceptionProvider()
    {
        $data = [            
            'no array query' => [
                'args' => [
                    'query' => 'pippo',
                ]
            ],
            'no query type' => [
                'args' => [
                    'query' => [],
                ]
            ],
            'no query type admited' => [
                'args' => [
                    'query' => [
                        'type' => 'pippo'
                    ],
                ]
            ] 
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::assemble
     * @dataProvider assembleExceptionProvider
     */
    public function testAssembleException($args)
    {
        $this->setExpectedException('Exception');
        
        Reflections::invokeMethod($this->db, 'assemble', $args);
    }
    
    /**
     * @group db
     * @coversNothing
     */
    public function prepareAllProvider()
    {
        $data = [
            'standard' => [
                'args' => [
                    'purgedQuery' => [
                        'fields' => [],
                        'table' => 'variabili_sync',
                        'where' => [],
                        'order' => [],
                        'type' => 'all'
                    ]
                ],
                'expected' => 'SELECT * FROM variabili_sync;'
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::prepareAll
     * @dataProvider prepareAllProvider
     */
    public function testPrepareAllEquals($args, $expected)
    {
        $actual = Reflections::invokeMethod($this->db, 'prepareAll', $args);
        
        $this->assertEquals($expected, $actual);         
    }
    
    /**
     * @group db
     * @coversNothing
     */
    public function prepareAllExceptionProvider()
    {
        $data = [            
            'no array query' => [
                'args' => [
                    'query' => 'pippo',
                ]
            ],
            'no query fields' => [
                'args' => [
                    'query' => [
                        'table' => [],
                        'order' => []
                    ]
                ]
            ],
            'no query table' => [
                'args' => [
                    'query' => [
                        'fields' => [],
                        'order' => []
                    ]
                ]
            ],
            'no query order' => [
                'args' => [
                    'query' => [
                        'fields' => [],
                        'table' => []
                    ]
                ]
            ]   
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::prepareAll
     * @dataProvider prepareAllExceptionProvider
     */
    public function testPrepareAllException($args)
    {
        $this->setExpectedException('Exception');
        
        Reflections::invokeMethod($this->db, 'prepareAll', $args);
    }
    
    /**
     * @group db
     * @coversNothing
     */
    public function prepareReadProvider()
    {
        $data = [
            'standard' => [
                'args' => [
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
                    ]
                ],
                'expected' => 'SELECT id_dato AS id, variabile, valore, CONVERT(varchar, data_e_ora, 20) AS data_e_ora, tipo_dato FROM dati_acquisiti WHERE (id_dato = :id_dato);'
            ],
            'no fields where order' => [
                'args' => [
                    'purgedQuery' => [
                        'fields' => [],
                        'table' => 'dati_acquisiti',
                        'where' => [],
                        'order' => [],
                        'type' => 'read'
                    ]
                ],
                'expected' => 'SELECT * FROM dati_acquisiti;'
            ],
            'no fields where' => [
                'args' => [
                    'purgedQuery' => [
                        'fields' => [],
                        'table' => 'dati_acquisiti',
                        'where' => [],
                        'order' => [
                            0 => [
                                'field' => 'data_e_ora',
                                'type' => 'asc'
                            ]
                        ],
                        'type' => 'read'
                    ]
                ],
                'expected' => 'SELECT * FROM dati_acquisiti ORDER BY data_e_ora ASC;'
            ],
            'no fields order' => [
                'args' => [
                    'purgedQuery' => [
                        'fields' => [],
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
                    ]
                ],
                'expected' => 'SELECT * FROM dati_acquisiti WHERE (id_dato = :id_dato);'
            ],
            'no fields' => [
                'args' => [
                    'purgedQuery' => [
                        'fields' => [],
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
                        'order' => [
                            0 => [
                                'field' => 'data_e_ora',
                                'type' => 'asc'
                            ]
                        ],
                        'type' => 'read'
                    ]
                ],
                'expected' => 'SELECT * FROM dati_acquisiti WHERE (id_dato = :id_dato) ORDER BY data_e_ora ASC;'
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::prepareRead
     * @dataProvider prepareReadProvider
     */
    public function testPrepareReadEquals($args, $expected)
    {
        $actual = Reflections::invokeMethod($this->db, 'prepareRead', $args);
        
        $this->assertEquals($expected, $actual);         
    }
    
    /**
     * @group db
     * @coversNothing
     */
    public function prepareReadExceptionProvider()
    {
        $data = [            
            'no array query' => [
                'args' => [
                    'query' => 'pippo',
                ]
            ],
            'no query fields' => [
                'args' => [
                    'query' => [
                        'table' => [],
                        'where' => [],
                        'order' => []
                    ]
                ]
            ],
            'no query table' => [
                'args' => [
                    'query' => [
                        'fields' => [],
                        'where' => [],
                        'order' => []
                    ]
                ]
            ],
            'no query where' => [
                'args' => [
                    'query' => [
                        'fields' => [],
                        'table' => [],
                        'order' => []
                    ]
                ]
            ],
            'no query order' => [
                'args' => [
                    'query' => [
                        'fields' => [],
                        'table' => [],
                        'where' => []
                    ]
                ]
            ]   
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::prepareRead
     * @dataProvider prepareReadExceptionProvider
     */
    public function testPrepareReadException($args)
    {
        $this->setExpectedException('Exception');
        
        Reflections::invokeMethod($this->db, 'prepareRead', $args);
    }
    
    /**
     * @group db
     * @coversNothing
     */
    public function prepareListProvider()
    {
        $data = [
            'standard' => [
                'args' => [
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
                    ]
                ],
                'expected' => 'SELECT id_dato AS id, variabile, valore, CONVERT(varchar, data_e_ora, 20) AS data_e_ora, tipo_dato FROM dati_acquisiti WHERE (variabile = :variabile AND tipo_dato = :tipoDato AND data_e_ora >= :dataIniziale AND data_e_ora < :dataFinale) ORDER BY data_e_ora ASC;'
            ],
            'no fields where order' => [
                'args' => [
                    'purgedQuery' => [
                        'fields' => [],
                        'table' => 'dati_acquisiti',
                        'where' => [],
                        'order' => [],
                        'type' => 'read'
                    ]
                ],
                'expected' => 'SELECT * FROM dati_acquisiti;'
            ],
            'no fields where' => [
                'args' => [
                    'purgedQuery' => [
                        'fields' => [],
                        'table' => 'dati_acquisiti',
                        'where' => [],
                        'order' => [
                            0 => [
                                'field' => 'data_e_ora',
                                'type' => 'asc'
                            ]
                        ],
                        'type' => 'read'
                    ]
                ],
                'expected' => 'SELECT * FROM dati_acquisiti ORDER BY data_e_ora ASC;'
            ],
            'no fields order' => [
                'args' => [
                    'purgedQuery' => [
                        'fields' => [],
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
                    ]
                ],
                'expected' => 'SELECT * FROM dati_acquisiti WHERE (id_dato = :id_dato);'
            ],
            'no fields' => [
                'args' => [
                    'purgedQuery' => [
                        'fields' => [],
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
                        'type' => 'read'
                    ]
                ],
                'expected' => 'SELECT * FROM dati_acquisiti WHERE (variabile = :variabile AND tipo_dato = :tipoDato AND data_e_ora >= :dataIniziale AND data_e_ora < :dataFinale) ORDER BY data_e_ora ASC;'
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::prepareList
     * @dataProvider prepareListProvider
     */
    public function testPrepareListEquals($args, $expected)
    {
        $actual = Reflections::invokeMethod($this->db, 'prepareList', $args);
        
        $this->assertEquals($expected, $actual);         
    }
    
    /**
     * @group db
     * @coversNothing
     */
    public function prepareListExceptionProvider()
    {
        $data = [            
            'no array query' => [
                'args' => [
                    'query' => 'pippo',
                ]
            ],
            'no query fields' => [
                'args' => [
                    'query' => [
                        'table' => [],
                        'where' => [],
                        'order' => []
                    ]
                ]
            ],
            'no query table' => [
                'args' => [
                    'query' => [
                        'fields' => [],
                        'where' => [],
                        'order' => []
                    ]
                ]
            ],
            'no query where' => [
                'args' => [
                    'query' => [
                        'fields' => [],
                        'table' => [],
                        'order' => []
                    ]
                ]
            ],
            'no query order' => [
                'args' => [
                    'query' => [
                        'fields' => [],
                        'table' => [],
                        'where' => []
                    ]
                ]
            ]   
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::prepareList
     * @dataProvider prepareListExceptionProvider
     */
    public function testPrepareListException($args)
    {
        $this->setExpectedException('Exception');
        
        Reflections::invokeMethod($this->db, 'prepareList', $args);
    }
    
    /**
     * @group db
     * @coversNothing
     */
    public function prepareCreateProvider()
    {
        $data = [
            'standard' => [
                'args' => [
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
                    ]
                ],
                'expected' => 'INSERT INTO dati_acquisiti (variabile, tipo_dato, data_e_ora, valore) VALUES (:variabile, :tipoDato, :data_e_ora, :valore);'
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::prepareCreate
     * @dataProvider prepareCreateProvider
     */
    public function testPrepareCreateEquals($args, $expected)
    {
        $actual = Reflections::invokeMethod($this->db, 'prepareCreate', $args);
        
        $this->assertEquals($expected, $actual);         
    }
    
    /**
     * @group db
     * @coversNothing
     */
    public function prepareCreateExceptionProvider()
    {
        $data = [            
            'no array query' => [
                'args' => [
                    'query' => 'pippo',
                ]
            ],
            'no query values' => [
                'args' => [
                    'query' => [
                        'table' => [],
                    ]
                ]
            ],
            'no query table' => [
                'args' => [
                    'query' => [
                        'values' => [],
                    ]
                ]
            ]   
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::prepareCreate
     * @dataProvider prepareCreateExceptionProvider
     */
    public function testPrepareCreateException($args)
    {
        $this->setExpectedException('Exception');
        
        Reflections::invokeMethod($this->db, 'prepareCreate', $args);
    }
    
    /**
     * @group db
     * @coversNothing
     */
    public function prepareUpdateProvider()
    {
        $data = [
            'standard' => [
                'args' => [
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
                    ]
                ],
                'expected' => 'UPDATE dati_acquisiti SET data_e_ora = :data_e_ora, valore = :valore WHERE (id_dato = :id_dato);'
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::prepareUpdate
     * @dataProvider prepareUpdateProvider
     */
    public function testPrepareUpdateEquals($args, $expected)
    {
        $actual = Reflections::invokeMethod($this->db, 'prepareUpdate', $args);
        
        $this->assertEquals($expected, $actual);         
    }
    
    /**
     * @group db
     * @coversNothing
     */
    public function prepareUpdateExceptionProvider()
    {
        $data = [            
            'no array query' => [
                'args' => [
                    'query' => 'pippo',
                ]
            ],
            'no query where' => [
                'args' => [
                    'query' => [
                        'table' => [],
                        'set' => []
                    ]
                ]
            ],
            'no query table' => [
                'args' => [
                    'query' => [
                        'values' => [],
                        'where' => []
                    ]
                ]
            ],
            'no query set' => [
                'args' => [
                    'query' => [
                        'table' => [],
                        'where' => []
                    ]
                ]
            ]   
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::prepareUpdate
     * @dataProvider prepareUpdateExceptionProvider
     */
    public function testPrepareUpdateException($args)
    {
        $this->setExpectedException('Exception');
        
        Reflections::invokeMethod($this->db, 'prepareUpdate', $args);
    }
    
    /**
     * @group db
     * @coversNothing
     */
    public function prepareDeleteProvider()
    {
        $data = [
            'standard' => [
                'args' => [
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
                    ]
                ],
                'expected' => 'DELETE FROM dati_acquisiti WHERE (id_dato = :id_dato);'
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::prepareDelete
     * @dataProvider prepareDeleteProvider
     */
    public function testPrepareDeleteEquals($args, $expected)
    {
        $actual = Reflections::invokeMethod($this->db, 'prepareDelete', $args);
        
        $this->assertEquals($expected, $actual);         
    }
    
    /**
     * @group db
     * @coversNothing
     */
    public function prepareDeleteExceptionProvider()
    {
        $data = [            
            'no array query' => [
                'args' => [
                    'query' => 'pippo',
                ]
            ],
            'no query where' => [
                'args' => [
                    'query' => [
                        'table' => []
                    ]
                ]
            ],
            'no query table' => [
                'args' => [
                    'query' => [
                        'where' => []
                    ]
                ]
            ]  
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::prepareDelete
     * @dataProvider prepareDeleteExceptionProvider
     */
    public function testPrepareDeleteException($args)
    {
        $this->setExpectedException('Exception');
        
        Reflections::invokeMethod($this->db, 'prepareDelete', $args);
    }
    
    /**
     * @group db
     * @coversNothing
     */
    public function setSelectFieldsProvider()
    {
        $data = [
            'standard' => [
                'args' => [
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
                    ]
                ],
                'expected' => 'id_dato AS id, variabile, valore, CONVERT(varchar, data_e_ora, 20) AS data_e_ora, tipo_dato'
            ],
            'no fields where order' => [
                'args' => [
                    'fields' => []
                ],
                'expected' => '*'
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::setSelectFields
     * @dataProvider setSelectFieldsProvider
     */
    public function testSetSelectFieldsEquals($args, $expected)
    {
        $actual = Reflections::invokeMethod($this->db, 'setSelectFields', $args);
        
        $this->assertEquals($expected, $actual);         
    }
    
    /**
     * @group db
     * @coversNothing
     */
    public function setSelectFieldsExceptionProvider()
    {
        $data = [            
            'no array fields' => [
                'args' => [
                    'fields' => 'pippo',
                ]
            ],
            'no name in fields' => [
                'args' => [
                    'fields' => [
                        0 => [
                            'alias' => 'pippo'
                        ]
                    ]
                ]
            ]   
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::setSelectFields
     * @dataProvider setSelectFieldsExceptionProvider
     */
    public function testSetSelectFieldsException($args)
    {
        $this->setExpectedException('Exception');
        
        Reflections::invokeMethod($this->db, 'setSelectFields', $args);
    }
    
    /**
     * @group db
     * @coversNothing
     */
    public function setTableProvider()
    {
        $data = [
            'standard' => [
                'args' => [
                    'table' => 'dati_acquisiti'
                ],
                'expected' => 'dati_acquisiti'
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::setTable
     * @dataProvider setTableProvider
     */
    public function testSetTableEquals($args, $expected)
    {
        $actual = Reflections::invokeMethod($this->db, 'setTable', $args);
        
        $this->assertEquals($expected, $actual);         
    }
    
    /**
     * @group db
     * @coversNothing
     */
    public function setTableExceptionProvider()
    {
        $data = [            
            'no string table' => [
                'args' => [
                    'table' => []
                ]
            ]   
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::setTable
     * @dataProvider setTableExceptionProvider
     */
    public function testSetTableException($args)
    {
        $this->setExpectedException('Exception');
        
        Reflections::invokeMethod($this->db, 'setTable', $args);
    }
    
    /**
     * @group db
     * @coversNothing
     */
    public function setWhereProvider()
    {
        $data = [
            'list' => [
                'args' => [
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
                    ]
                ],
                'expected' => '(variabile = :variabile AND tipo_dato = :tipoDato AND data_e_ora >= :dataIniziale AND data_e_ora < :dataFinale)'
            ],
            'read update delete' => [
                'args' => [
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
                'expected' => '(id_dato = :id_dato)'
            ],
            '2and1or' => [
                'args' => [
                    'where' => [
                        'and' => [
                            'or' => [
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
                                ]
                            ],
                            'or2' => [
                                0 => [
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
                                1 => [
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
                        ]
                    ]
                ],
                'expected' => '((variabile = :variabile OR tipo_dato = :tipoDato) AND (data_e_ora >= :dataIniziale OR data_e_ora < :dataFinale))'
            ],
            '1and2or' => [
                'args' => [
                    'where' => [
                        'or' => [
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
                                ]
                            ],
                            'and2' => [
                                0 => [
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
                                1 => [
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
                        ]
                    ]
                ],
                'expected' => '((variabile = :variabile AND tipo_dato = :tipoDato) OR (data_e_ora >= :dataIniziale AND data_e_ora < :dataFinale))'
            ],
            'no where' => [
                'args' => [
                    'where' => []
                ],
                'expected' => null
            ]
            
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::setWhere
     * @dataProvider setWhereProvider
     */
    public function testSetWhereEquals($args, $expected)
    {
        $actual = Reflections::invokeMethod($this->db, 'setWhere', $args);
        
        $this->assertEquals($expected, $actual);         
    }
    
    /**
     * @group db
     * @coversNothing
     */
    public function setWhereExceptionProvider()
    {
        $data = [            
            'no array where' => [
                'args' => [
                    'where' => 'pippo'
                ]
            ],
            'wrong where' => [
                'args' => [
                    'where' => [
                        'pippo' => [
                            0 => []
                        ]
                    ]
                ]
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::setWhere
     * @dataProvider setWhereExceptionProvider
     */
    public function testSetWhereException($args)
    {
        $this->setExpectedException('Exception');
        
        Reflections::invokeMethod($this->db, 'setWhere', $args);
    }
    
    /**
     * @group db
     * @coversNothing
     */
    public function setWhereRecursiveProvider()
    {
        $data = [
            'list' => [
                'args' => [
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
                    ]
                ],
                'expected' => [
                    0 => '(variabile = :variabile AND tipo_dato = :tipoDato AND data_e_ora >= :dataIniziale AND data_e_ora < :dataFinale)'
                ]
            ],
            'read update delete' => [
                'args' => [
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
                'expected' => [
                    0 => '(id_dato = :id_dato)'
                ]
            ],
            '2and1or' => [
                'args' => [
                    'where' => [
                        'and' => [
                            'or' => [
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
                                ]
                            ],
                            'or2' => [
                                0 => [
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
                                1 => [
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
                        ]
                    ]
                ],
                'expected' => [
                    0 => '((variabile = :variabile OR tipo_dato = :tipoDato) AND (data_e_ora >= :dataIniziale OR data_e_ora < :dataFinale))'
                ]
            ],
            '1and2or' => [
                'args' => [
                    'where' => [
                        'or' => [
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
                                ]
                            ],
                            'and2' => [
                                0 => [
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
                                1 => [
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
                        ]
                    ]
                ],
                'expected' => [
                    0 => '((variabile = :variabile AND tipo_dato = :tipoDato) OR (data_e_ora >= :dataIniziale AND data_e_ora < :dataFinale))'
                ]
            ],
            'no where' => [
                'args' => [
                    'where' => []
                ],
                'expected' => null
            ]
            
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::setWhereRecursive
     * @dataProvider setWhereRecursiveProvider
     */
    public function testSetWhereRecursiveEquals($args, $expected)
    {
        $actual = Reflections::invokeMethod($this->db, 'setWhereRecursive', $args);
        
        $this->assertEquals($expected, $actual);         
    }
    
    /**
     * @group db
     * @coversNothing
     */
    public function setWhereRecursiveExceptionProvider()
    {
        $data = [            
            'no array where' => [
                'args' => [
                    'where' => 'pippo'
                ]
            ],
            'wrong where no field' => [
                'args' => [
                    'where' => [
                        'and' => [
                            0 => [
                                'operator' => '=',
                                'value' => [
                                    'bind' => ':id_dato'                                    
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'wrong where no operator' => [
                'args' => [
                    'where' => [
                        'and' => [
                            0 => [
                                'field' => 'id_dato',
                                'value' => [
                                    'bind' => ':id_dato'                                    
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'wrong where no value' => [
                'args' => [
                    'where' => [
                        'and' => [
                            0 => [
                                'field' => 'id_dato',
                                'operator' => '=',
                            ]
                        ]
                    ]
                ]
            ],
            'wrong where no value bind' => [
                'args' => [
                    'where' => [
                        'and' => [
                            0 => [
                                'field' => 'id_dato',
                                'operator' => '=',
                                'value' => [
                                    'pippo' => ':id_dato'                                    
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::setWhereRecursive
     * @dataProvider setWhereRecursiveExceptionProvider
     */
    public function testSetWhereRecursiveException($args)
    {
        $this->setExpectedException('Exception');
        
        Reflections::invokeMethod($this->db, 'setWhereRecursive', $args);
    }
    
    /**
     * @group db
     * @coversNothing
     */
    public function setOrderProvider()
    {
        $data = [
            'no order' => [
                'args' => [
                    'order' => []
                ],
                'expected' => null
            ],
            'order 1 field' => [
                'args' => [
                    'order' => [
                        0 => [
                            'field' => 'data_e_ora',
                            'type' => 'asc'
                        ]
                    ]
                ],
                'expected' => 'data_e_ora ASC'
            ],
            'order more fields' => [
                'args' => [
                    'order' => [
                        0 => [
                            'field' => 'variabile',
                            'type' => 'asc'
                        ],
                        1 => [
                            'field' => 'data_e_ora',
                            'type' => 'desc'
                        ]
                    ]
                ],
                'expected' => 'variabile ASC, data_e_ora DESC'
            ]            
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::setOrder
     * @dataProvider setOrderProvider
     */
    public function testSetOrderEquals($args, $expected)
    {
        $actual = Reflections::invokeMethod($this->db, 'setOrder', $args);
        
        $this->assertEquals($expected, $actual);         
    }
    
    /**
     * @group db
     * @coversNothing
     */
    public function setOrderExceptionProvider()
    {
        $data = [            
            'no array order' => [
                'args' => [
                    'order' => 'pippo'
                ]
            ],
            'wrong order no field' => [
                'args' => [
                    'where' => [
                        0 => [
                            'type' => 'desc'
                        ]
                    ]
                ]
            ],
            'wrong order no type' => [
                'args' => [
                    'where' => [
                        0 => [
                            'field' => 'data_e_ora'
                        ]
                    ]
                ]
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::setOrder
     * @dataProvider setOrderExceptionProvider
     */
    public function testSetOrderException($args)
    {
        $this->setExpectedException('Exception');
        
        Reflections::invokeMethod($this->db, 'setOrder', $args);
    }
    
    /**
     * @group db
     * @coversNothing
     */
    public function setInsertFieldsProvider()
    {
        $data = [
            'create' => [
                'args' => [
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
                'expected' => 'variabile, tipo_dato, data_e_ora, valore'
            ]           
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::setInsertFields
     * @dataProvider setInsertFieldsProvider
     */
    public function testSetInsertFieldsEquals($args, $expected)
    {
        $actual = Reflections::invokeMethod($this->db, 'setInsertFields', $args);
        
        $this->assertEquals($expected, $actual);         
    }
    
    /**
     * @group db
     * @coversNothing
     */
    public function setInsertFieldsExceptionProvider()
    {
        $data = [
            'no array values' => [
                'args' => [
                    'values' => 'pippo'
                ]
            ],
            'no array insert field' => [
                'args' => [
                    'values' => [
                        'value' => []
                    ]
                ]
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::setInsertFields
     * @dataProvider setInsertFieldsExceptionProvider
     */
    public function testSetInsertFieldsException($args)
    {
        $this->setExpectedException('Exception');
        
        Reflections::invokeMethod($this->db, 'setInsertFields', $args);
    }
    
    /**
     * @group db
     * @coversNothing
     */
    public function setValuesProvider()
    {
        $data = [
            'create' => [
                'args' => [
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
                'expected' => ':variabile, :tipoDato, :data_e_ora, :valore'
            ]           
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::setValues
     * @dataProvider setValuesProvider
     */
    public function testSetValuesEquals($args, $expected)
    {
        $actual = Reflections::invokeMethod($this->db, 'setValues', $args);
        
        $this->assertEquals($expected, $actual);         
    }
    
    /**
     * @group db
     * @coversNothing
     */
    public function setValuesExceptionProvider()
    {
        $data = [
            'no array values' => [
                'args' => [
                    'values' => 'pippo'
                ]
            ],
            'no array insert value' => [
                'args' => [
                    'values' => [
                        'pippo' => [
                            'bind' => ':valore'
                        ]
                    ]
                ]
            ],
            'no array insert value bind' => [
                'args' => [
                    'values' => [
                        'value' => [
                            'pippo' => ':valore'
                        ]
                    ]
                ]
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::setValues
     * @dataProvider setValuesExceptionProvider
     */
    public function testSetValuesException($args)
    {
        $this->setExpectedException('Exception');
        
        Reflections::invokeMethod($this->db, 'setValues', $args);
    }
    
    /**
     * @group db
     * @coversNothing
     */
    public function setSetsProvider()
    {
        $data = [
            'update' => [
                'args' => [
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
                    ]
                ],
                'expected' => 'data_e_ora = :data_e_ora, valore = :valore'
            ]           
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::setSets
     * @dataProvider setSetsProvider
     */
    public function testSetSetsEquals($args, $expected)
    {
        $actual = Reflections::invokeMethod($this->db, 'setSets', $args);
        
        $this->assertEquals($expected, $actual);         
    }
    
    /**
     * @group db
     * @coversNothing
     */
    public function setSetsExceptionProvider()
    {
        $data = [
            'no array set' => [
                'args' => [
                    'set' => 'pippo'
                ]
            ],
            'no array set field' => [
                'args' => [
                    'values' => [
                        0 => [
                            'pippo' => 'valore',
                            'value' => [
                                'bind' => ':valore'
                            ]
                        ]
                    ]
                ]
            ],
            'no array set value' => [
                'args' => [
                    'values' => [
                        0 => [
                            'field' => 'valore',
                            'pippo' => [
                                'bind' => ':valore'
                            ]
                        ]
                    ]
                ]
            ],
            'no array set value bind' => [
                'args' => [                    
                    'values' => [
                        0 => [
                            'field' => 'valore',
                            'value' => [
                                'pippo' => ':valore'
                            ]
                        ]
                    ]
                ]
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::setSets
     * @dataProvider setSetsExceptionProvider
     */
    public function testSetSetsException($args)
    {
        $this->setExpectedException('Exception');
        
        Reflections::invokeMethod($this->db, 'setSets', $args);
    }
    
    /**
     * @group db
     * @coversNothing
     */
    public function prepareProvider()
    {
        $data = [
            'all' => [
                'query' => 'SELECT * FROM variabili_sync;'
            ],
            'read' => [
                'query' => 'SELECT id_dato AS id, variabile, valore, CONVERT(varchar, data_e_ora, 20) AS data_e_ora, tipo_dato FROM dati_acquisiti WHERE (id_dato = :id_dato);'
            ],
            'list' => [
                'query' => 'SELECT id_dato AS id, variabile, valore, CONVERT(varchar, data_e_ora, 20) AS data_e_ora, tipo_dato FROM dati_acquisiti WHERE (variabile = :variabile AND tipo_dato = :tipoDato AND data_e_ora >= :dataIniziale AND data_e_ora < :dataFinale) ORDER BY data_e_ora ASC;'
            ],
            'create' => [
                'query' => 'INSERT INTO dati_acquisiti (variabile, tipo_dato, data_e_ora, valore) VALUES (:variabile, :tipoDato, :data_e_ora, :valore);'
            ],
            'update' => [
                'query' => 'UPDATE dati_acquisiti SET data_e_ora = :data_e_ora, valore = :valore WHERE (id_dato = :id_dato);'
            ],
            'delete' => [
                'query' => 'DELETE FROM dati_acquisiti WHERE (id_dato = :id_dato);'
            ]            
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::prepare
     * @dataProvider prepareProvider
     */
    public function testPrepareInstanceOf($query)
    {
        Reflections::setProperty($this->db, 'query', $query);
        Reflections::invokeMethod($this->db, 'connect');
        Reflections::invokeMethod($this->db, 'prepare');        
        $actual = Reflections::getProperty($this->db, 'pdoStmt');                
        
        $this->assertInstanceOf('PDOStatement', $actual);         
    }
    
    /**
     * @group db
     * @coversNothing
     */
    public function prepareExceptionProvider()
    {
        $data = [
            'wrong query' => [
                'query' => []
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::prepare
     * @dataProvider prepareExceptionProvider
     */
    public function testPrepareException($query)
    {
        $this->setExpectedException('Exception');
        
        Reflections::setProperty($this->db, 'query', $query);
        Reflections::invokeMethod($this->db, 'connect');
        Reflections::invokeMethod($this->db, 'prepare');
    }
    
    /**
     * @group db
     * @coversNothing
     */
    public function setIdProvider()
    {
        $data = [
            'all' => [
                'args' => [
                    'bindParams' => []
                ],
                'expected' => null
            ],
            'read' => [
                'args' => [
                    'bindParams' => [
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
                'expected' => '97047202'
            ],
            'list' => [
                'args' => [
                    'bindParams' => [
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
                            'value' => '2018-10-18 01:00:00'
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
                            'value' => '2018-10-18 01:30:00'
                        ]
                    ]
                ],
                'expected' => null
            ],
            'create' => [
                'args' => [
                    'bindParams' => [
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
                            'value' => '2018-10-20 01:00:00'
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
                    ]
                ],
                'expected' => null
            ],
            'update' => [
                'args' => [
                    'bindParams' => [
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
                            'value' => '2018-10-20 01:30:00'
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
                    ]
                ],
                'expected' => '101540010'
            ],
            'delete' => [
                'args' => [
                    'bindParams' => [
                        0 => [
                            'param' => 'id',
                            'bind' => ':id_dato',
                            'type' => 'int',
                            'null' => false,
                            'check' => [
                                'type' => 'integer',
                                'params' => []
                            ],
                            'value' => '999999999'
                        ]
                    ]
                ],
                'expected' => '999999999'
            ]            
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::setId
     * @dataProvider setIdProvider
     */
    public function testSetIdEquals($args, $expected)
    {
        Reflections::invokeMethod($this->db, 'setId', $args);
        
        $actual = Reflections::getProperty($this->db, 'id');
        
        $this->assertEquals($expected, $actual); 
    }
    
    /**
     * @group db
     * @coversNothing
     */
    public function setIdExceptionProvider()
    {
        $data = [            
            'no array params' => [
                'args' => [
                    'params' => 'pippo'
                ]
            ],
            'no array params param' => [
                'args' => [
                    'params' => [
                        0 => [
                            'pippo' => 'id',
                            'value' => '999999999'
                        ]
                    ]
                ]
            ],
            'no array params value' => [
                'args' => [
                    'params' => [
                        0 => [
                            'param' => 'id',
                            'pippo' => '999999999'
                        ]
                    ]
                ]
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::setId
     * @dataProvider setIdExceptionProvider
     */
    public function testSetIdException($args)
    {
        $this->setExpectedException('Exception');
        
        Reflections::invokeMethod($this->db, 'setId', $args);
    }
    
    /**
     * @group db
     * @coversNothing
     */
    public function bindProvider()
    {
        $data = [
            'all' => [
                'query' => 'SELECT * FROM variabili_sync;',
                'args' => [
                    'bindParams' => []
                ]
            ],
            'read' => [
                'query' => 'SELECT id_dato AS id, variabile, valore, CONVERT(varchar, data_e_ora, 20) AS data_e_ora, tipo_dato FROM dati_acquisiti WHERE (id_dato = :id_dato);',
                'args' => [
                    'bindParams' => [
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
                ]
            ],
            'list' => [
                'query' => 'SELECT id_dato AS id, variabile, valore, CONVERT(varchar, data_e_ora, 20) AS data_e_ora, tipo_dato FROM dati_acquisiti WHERE (variabile = :variabile AND tipo_dato = :tipoDato AND data_e_ora >= :dataIniziale AND data_e_ora < :dataFinale) ORDER BY data_e_ora ASC;',
                'args' => [
                    'bindParams' => [
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
                            'value' => '2018-10-18 01:00:00'
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
                            'value' => '2018-10-18 01:30:00'
                        ]
                    ]
                ]
            ],
            'create' => [
                'query' => 'INSERT INTO dati_acquisiti (variabile, tipo_dato, data_e_ora, valore) VALUES (:variabile, :tipoDato, :data_e_ora, :valore);',
                'args' => [
                    'bindParams' => [
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
                            'value' => '2018-10-20 01:00:00'
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
                    ]
                ]
            ],
            'update' => [
                'query' => 'UPDATE dati_acquisiti SET data_e_ora = :data_e_ora, valore = :valore WHERE (id_dato = :id_dato);',
                'args' => [
                    'bindParams' => [
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
                            'value' => '2018-10-20 01:30:00'
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
                    ]
                ]
            ],
            'delete' => [
                'query' => 'DELETE FROM dati_acquisiti WHERE (id_dato = :id_dato);',
                'args' => [
                    'bindParams' => [
                        0 => [
                            'param' => 'id',
                            'bind' => ':id_dato',
                            'type' => 'int',
                            'null' => false,
                            'check' => [
                                'type' => 'integer',
                                'params' => []
                            ],
                            'value' => '999999999'
                        ]
                    ]
                ]
            ]          
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::bind
     * @dataProvider bindProvider
     */
    public function testBindTrue($query, $args)
    {
        Reflections::setProperty($this->db, 'query', $query);
        Reflections::invokeMethod($this->db, 'connect');
        Reflections::invokeMethod($this->db, 'prepare');
        $actual = Reflections::invokeMethod($this->db, 'bind', $args);
        
        $this->assertTrue($actual);
    }
    
    /**
     * @group db
     * @coversNothing
     */
    public function bindExceptionProvider()
    {
        $data = [            
            'no array params' => [
                'args' => [
                    'params' => 'pippo'
                ]
            ],
            'no array params type' => [
                'args' => [
                    'params' => [
                        0 => [
                            'pippo' => 'int',
                            'bind' => ':id_dato',
                            'value' => '999999999'
                        ]
                    ]
                ]
            ],
            'no array params type error' => [
                'args' => [
                    'params' => [
                        0 => [
                            'type' => 'pippo',
                            'bind' => ':id_dato',
                            'value' => '999999999'
                        ]
                    ]
                ]
            ],
            'no array params bind' => [
                'args' => [
                    'params' => [
                        0 => [
                            'type' => 'int',
                            'pippo' => ':id_dato',
                            'value' => '999999999'
                        ]
                    ]
                ]
            ],
            'no array params value' => [
                'args' => [
                    'params' => [
                        0 => [
                            'type' => 'int',
                            'bind' => ':id_dato',
                            'pippo' => '999999999'
                        ]
                    ]
                ]
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::bind
     * @dataProvider bindExceptionProvider
     */
    public function testBindException($args)
    {
        $this->setExpectedException('Exception');
        
        Reflections::invokeMethod($this->db, 'bind', $args);
    }
    
    /**
     * @group db
     * @coversNothing
     */
    public function execProvider()
    {
        $data = [
            'all' => [
                'method' => 'all',
                'query' => 'SELECT * FROM variabili_sync;',
                'params' => [
                    'bindParams' => []
                ]
            ],
            'read' => [
                'method' => 'read',
                'query' => 'SELECT id_dato AS id, variabile, valore, CONVERT(varchar, data_e_ora, 20) AS data_e_ora, tipo_dato FROM dati_acquisiti WHERE (id_dato = :id_dato);',
                'params' => [
                    'bindParams' => [
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
                ]
            ],
            'list' => [
                'method' => 'list',
                'query' => 'SELECT id_dato AS id, variabile, valore, CONVERT(varchar, data_e_ora, 20) AS data_e_ora, tipo_dato FROM dati_acquisiti WHERE (variabile = :variabile AND tipo_dato = :tipoDato AND data_e_ora >= :dataIniziale AND data_e_ora < :dataFinale) ORDER BY data_e_ora ASC;',
                'params' => [
                    'bindParams' => [
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
                            'value' => '2018-10-18 01:00:00'
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
                            'value' => '2018-10-18 01:30:00'
                        ]
                    ]
                ]
            ],
            'create' => [
                'method' => 'create',
                'query' => 'INSERT INTO dati_acquisiti (variabile, tipo_dato, data_e_ora, valore) VALUES (:variabile, :tipoDato, :data_e_ora, :valore);',
                'params' => [
                    'bindParams' => [
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
                            'value' => '2018-10-20 01:00:00'
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
                    ]
                ]
            ],
            'update' => [
                'method' => 'update',
                'query' => 'UPDATE dati_acquisiti SET data_e_ora = :data_e_ora, valore = :valore WHERE (id_dato = :id_dato);',
                'params' => [
                    'bindParams' => [
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
                            'value' => '2018-10-20 01:30:00'
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
                    ]
                ]
            ],
            'delete' => [
                'method' => 'delete',
                'query' => 'DELETE FROM dati_acquisiti WHERE (id_dato = :id_dato);',
                'params' => [
                    'bindParams' => [
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
                    ]
                ]
            ]          
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::exec
     * @dataProvider execProvider
     */
    public function testExecTrue($method, $query, $params)
    {
        $jsonId = file_get_contents(__DIR__ . '/../providers/wrapper.json');
        $arrJson = json_decode($jsonId, true);
        $newId = $arrJson['id_dato'];
        
        if ($method === 'delete') {            
            $params['bindParams'][0]['value'] = str_replace('@id@', $newId, $params['bindParams'][0]['value']);
        }
        
        if ($method === 'all') {
            $this->db = New Db('dbcore');
        } else {
            $this->db = New Db('SPT');
        }
        
        Reflections::setProperty($this->db, 'query', $query);
        Reflections::invokeMethod($this->db, 'connect');
        Reflections::invokeMethod($this->db, 'prepare');
        Reflections::invokeMethod($this->db, 'bind', $params);
        $actual = Reflections::invokeMethod($this->db, 'exec');
        
        $this->assertTrue($actual);
        
        if ($method === 'delete') {            
            file_put_contents(__DIR__ . '/../providers/wrapper.json','{"id_dato":' . ($newId + 1) . '}');
        }
    }
    
    /**
     * @group db
     * @coversNothing
     */
    public function execExceptionProvider()
    {
        $data = [            
            'wrong query' => [
                'query' => 'SELEC * FROM dati_acquisiti WHERE (id_dato = :id_dato);',
                'bindParams' => [
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
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::exec
     * @dataProvider execExceptionProvider
     */
    public function testExecException($args)
    {
        $this->setExpectedException('Exception');
        
        Reflections::setProperty($this->db, 'query', $query);
        Reflections::invokeMethod($this->db, 'connect');
        Reflections::invokeMethod($this->db, 'prepare');
        Reflections::invokeMethod($this->db, 'bind', $params);
        
        Reflections::invokeMethod($this->db, 'exec');
    }
    
    /**
     * @group db
     * @coversNothing
     */
    public function getResultsProvider()
    {
        $data = [
            'all' => [
                'method' => 'all',
                'query' => 'SELECT COUNT(*) AS n_record FROM variabili_sync;',
                'params' => [
                    'bindParams' => []
                ],
                'id' => null,
                'expected' => [                    
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
                'method' => 'read',
                'query' => 'SELECT id_dato AS id, variabile, valore, CONVERT(varchar, data_e_ora, 20) AS data_e_ora, tipo_dato FROM dati_acquisiti WHERE (id_dato = :id_dato);',
                'params' => [
                    'bindParams' => [
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
                'id' => '97047202',
                'expected' => [                    
                    'type' => 'read',
                    'records' => [
                        0 => [
                            'id' => '97047202',
                            'variabile' => '82025',
                            'valore' => '0',
                            'data_e_ora' => '2018-10-28 01:00:00',
                            'tipo_dato' => '2'
                        ]
                    ],
                    'id' => '97047202'                    
                ]
            ],
            'list' => [
                'method' => 'list',
                'query' => 'SELECT id_dato AS id, variabile, valore, CONVERT(varchar, data_e_ora, 20) AS data_e_ora, tipo_dato FROM dati_acquisiti WHERE (variabile = :variabile AND tipo_dato = :tipoDato AND data_e_ora >= :dataIniziale AND data_e_ora < :dataFinale) ORDER BY data_e_ora ASC;',
                'params' => [
                    'bindParams' => [
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
                            'value' => '2018-10-18 01:00:00'
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
                            'value' => '2018-10-18 01:30:00'
                        ]
                    ]
                ],
                'id' => null,
                'expected' => [
                    'type' => 'list',
                    'records' => [
                        0 => [
                            'id' => '96776451',
                            'variabile' => '82025',
                            'valore' => '0',
                            'data_e_ora' => '2018-10-18 01:00:00',
                            'tipo_dato' => '2'
                        ]
                    ],
                    'id' => null
                ]
            ],
            'create' => [
                'method' => 'create',
                'query' => 'INSERT INTO dati_acquisiti (variabile, tipo_dato, data_e_ora, valore) VALUES (:variabile, :tipoDato, :data_e_ora, :valore);',
                'params' => [
                    'bindParams' => [
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
                            'value' => '2018-10-20 01:00:00'
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
                    ]
                ],
                'id' => null,
                'expected' => [
                    'type' => 'create',
                    'records' => [],
                    'id' => '@id@'
                ]
            ],
            'update' => [
                'method' => 'update',
                'query' => 'UPDATE dati_acquisiti SET data_e_ora = :data_e_ora, valore = :valore WHERE (id_dato = :id_dato);',
                'params' => [
                    'bindParams' => [
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
                            'value' => '2018-10-20 01:30:00'
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
                    ]
                ],
                'id' => '101540010',
                'expected' => [
                    'type' => 'update',
                    'records' => [],
                    'id' => '101540010'
                ]
            ],
            'delete' => [
                'method' => 'delete',
                'query' => 'DELETE FROM dati_acquisiti WHERE (id_dato = :id_dato);',
                'params' => [
                    'bindParams' => [
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
                    ]
                ],
                'id' => '@id@',
                'expected' => [
                    'type' => 'delete',
                    'records' => [],
                    'id' => '@id@'
                ]
            ]
            
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::getResults
     * @dataProvider getResultsProvider
     */
    public function testGetResultsEquals($method, $query, $params, $id, $expected)
    {
        $jsonId = file_get_contents(__DIR__ . '/../providers/wrapper.json');
        $arrJson = json_decode($jsonId, true);
        $newId = $arrJson['id_dato'];
        
        if ($method === 'delete') {            
            $params['bindParams'][0]['value'] = str_replace('@id@', $newId, $params['bindParams'][0]['value']);
            $id = str_replace('@id@', $newId, $id);
            $expected['id'] = str_replace('@id@', $newId, $expected['id']);
        }
        
        if ($method === 'create') {
            $expected['id'] = str_replace('@id@', $newId, $expected['id']);
        }
        
        if ($method === 'all') {
            $this->db = New Db('dbcore');
        } else {
            $this->db = New Db('SPT');
        }
        
        Reflections::setProperty($this->db, 'queryType', $method);
        Reflections::setProperty($this->db, 'query', $query);
        Reflections::setProperty($this->db, 'id', $id);
        Reflections::invokeMethod($this->db, 'connect');
        Reflections::invokeMethod($this->db, 'prepare');
        Reflections::invokeMethod($this->db, 'bind', $params);
        Reflections::invokeMethod($this->db, 'exec');
        $actual = Reflections::invokeMethod($this->db, 'getResults');
        
        $this->assertEquals($expected, $actual); 
        
        if ($method === 'delete') {            
            file_put_contents(__DIR__ . '/../providers/wrapper.json','{"id_dato":' . ($newId + 1) . '}');
        }
    }

    /**
     * @group db
     * @coversNothing
     */
    public function goProvider()
    {
        $data = [
            'all' => [
                'method' => 'all',
                'query' => 'SELECT COUNT(*) AS n_record FROM variabili_sync;',
                'expected' => [                    
                    'type' => 'list',
                    'records' => [
                        0 => [
                            'n_record' => '44'
                        ]
                    ],
                    'id' => null                    
                ]
            ],
            'read' => [
                'method' => 'read',
                'query' => 'SELECT id_dato AS id, variabile, valore, CONVERT(varchar, data_e_ora, 20) AS data_e_ora, tipo_dato FROM dati_acquisiti WHERE (id_dato = 97047202);',
                'expected' => [                    
                    'type' => 'list',
                    'records' => [
                        0 => [
                            'id' => '97047202',
                            'variabile' => '82025',
                            'valore' => '0',
                            'data_e_ora' => '2018-10-28 01:00:00',
                            'tipo_dato' => '2'
                        ]
                    ],
                    'id' => null                    
                ]
            ],
            'list' => [
                'method' => 'list',
                'query' => "SELECT id_dato AS id, variabile, valore, CONVERT(varchar, data_e_ora, 20) AS data_e_ora, tipo_dato FROM dati_acquisiti WHERE (variabile = 82025 AND tipo_dato = 2 AND data_e_ora >= '2018-10-18 01:00:00' AND data_e_ora < '2018-10-18 01:30:00') ORDER BY data_e_ora ASC;",
                'expected' => [
                    'type' => 'list',
                    'records' => [
                        0 => [
                            'id' => '96776451',
                            'variabile' => '82025',
                            'valore' => '0',
                            'data_e_ora' => '2018-10-18 01:00:00',
                            'tipo_dato' => '2'
                        ]
                    ],
                    'id' => null
                ]
            ],
            'create' => [
                'method' => 'create',
                'query' => "INSERT INTO dati_acquisiti (variabile, tipo_dato, data_e_ora, valore) VALUES (82025, 2, '2018-10-20 01:00:00', 3.5);",
                'expected' => [
                    'type' => 'create',
                    'records' => [],
                    'id' => '@id@'
                ]
            ],
            'update' => [
                'method' => 'update',
                'query' => "UPDATE dati_acquisiti SET data_e_ora = '2018-10-20 01:30:00', valore = 1.9 WHERE (id_dato = 101540010);",
                'expected' => [
                    'type' => 'update',
                    'records' => [],
                    'id' => null
                ]
            ],
            'delete' => [
                'method' => 'delete',
                'query' => 'DELETE FROM dati_acquisiti WHERE (id_dato = @id@);',
                'expected' => [
                    'type' => 'delete',
                    'records' => [],
                    'id' => null
                ]
            ]
            
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::go
     * @dataProvider goProvider
     */
    public function testGoEquals($method, $query, $expected)
    {
        $jsonId = file_get_contents(__DIR__ . '/../providers/wrapper.json');
        $arrJson = json_decode($jsonId, true);
        $newId = $arrJson['id_dato'];
        
        if ($method === 'delete') {            
            $query = str_replace('@id@', $newId, $query);
        }
        
        if ($method === 'create') {
            $expected['id'] = str_replace('@id@', $newId, $expected['id']);
        }
        
        if ($method === 'all') {
            $this->db = New Db('dbcore');
        } else {
            $this->db = New Db('SPT');
        }
        
        $actual = Reflections::invokeMethod($this->db, 'go', array($query));
        
        $this->assertEquals($expected, $actual); 
        
        if ($method === 'delete') {            
            file_put_contents(__DIR__ . '/../providers/wrapper.json','{"id_dato":' . ($newId + 1) . '}');
        }
    }
    
    /**
     * @group db
     * @coversNothing
     */
    public function goExceptionProvider()
    {
        $data = [            
            'no string query' => [
                'args' => [
                    'query' => []
                ]
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::go
     * @dataProvider goExceptionProvider
     */
    public function testGoException($args)
    {
        $this->setExpectedException('Exception');
        
        Reflections::invokeMethod($this->db, 'go', $args);
    }
    
    /**
     * @group db
     * @coversNothing
     */
    public function checkQueryProvider()
    {
        $data = [
            'all' => [
                'query' => 'SELECT * FROM variabili_sync;',
                'expected' => 'list'
            ],
            'read' => [
                'query' => 'SELECT id_dato AS id, variabile, valore, CONVERT(varchar, data_e_ora, 20) AS data_e_ora, tipo_dato FROM dati_acquisiti WHERE (id_dato = 97047202);',
                'expected' => 'list'
            ],
            'list' => [
                'query' => "SELECT id_dato AS id, variabile, valore, CONVERT(varchar, data_e_ora, 20) AS data_e_ora, tipo_dato FROM dati_acquisiti WHERE (variabile = 82025 AND tipo_dato = 2 AND data_e_ora >= '2018-10-18 01:00:00' AND data_e_ora < '2018-10-18 01:30:00') ORDER BY data_e_ora ASC;",
                'expected' => 'list'
            ],
            'create' => [
                'query' => "INSERT INTO dati_acquisiti (variabile, tipo_dato, data_e_ora, valore) VALUES (82025, 2, '2018-10-20 01:00:00', 3.5);",
                'expected' => 'create'
            ],
            'update' => [
                'query' => "UPDATE dati_acquisiti SET data_e_ora = '2018-10-20 01:30:00', valore = 1.9 WHERE (id_dato = 101540010);",
                'expected' => 'update'
            ],
            'delete' => [
                'query' => 'DELETE FROM dati_acquisiti WHERE (id_dato = 999999999);',
                'expected' => 'delete'
            ]
            
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::checkQuery
     * @dataProvider checkQueryProvider
     */
    public function testCheckQueryEquals($query, $expected)
    {
        Reflections::invokeMethod($this->db, 'checkQuery', array($query));
        $actual = Reflections::getProperty($this->db, 'queryType');
        
        $this->assertEquals($expected, $actual);
        
        $actual = Reflections::getProperty($this->db, 'query');
        
        $this->assertEquals($query, $actual);
    }
    
    /**
     * @group db
     * @coversNothing
     */
    public function checkQueryExceptionProvider()
    {
        $data = [            
            'no string query' => [
                'args' => [
                    'query' => []
                ]
            ],
            'wrong query' => [
                'args' => [
                    'query' => 'pippo'
                ]
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::checkQuery
     * @dataProvider checkQueryExceptionProvider
     */
    public function testCheckQueryException($args)
    {
        $this->setExpectedException('Exception');
        
        Reflections::invokeMethod($this->db, 'checkQuery', $args);
    }
    
    /**
     * @group db
     * @coversNothing
     */
    public function queryProvider()
    {
        $data = [
            'all' => [
                'query' => 'SELECT * FROM variabili_sync;'
            ],
            'read' => [
                'query' => 'SELECT id_dato AS id, variabile, valore, CONVERT(varchar, data_e_ora, 20) AS data_e_ora, tipo_dato FROM dati_acquisiti WHERE (id_dato = 97047202);'
            ],
            'list' => [
                'query' => "SELECT id_dato AS id, variabile, valore, CONVERT(varchar, data_e_ora, 20) AS data_e_ora, tipo_dato FROM dati_acquisiti WHERE (variabile = 82025 AND tipo_dato = 2 AND data_e_ora >= '2018-10-18 01:00:00' AND data_e_ora < '2018-10-18 01:30:00') ORDER BY data_e_ora ASC;"
            ],
            'create' => [
                'query' => "INSERT INTO dati_acquisiti (variabile, tipo_dato, data_e_ora, valore) VALUES (82025, 2, '2018-10-20 01:00:00', 3.5);"
            ],
            'update' => [
                'query' => "UPDATE dati_acquisiti SET data_e_ora = '2018-10-20 01:30:00', valore = 1.9 WHERE (id_dato = 101540010);"
            ],
            'delete' => [
                'query' => 'DELETE FROM dati_acquisiti WHERE (id_dato = @id@);'
            ]
            
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::query
     * @dataProvider queryProvider
     */
    public function testQueryEquals($query)
    {
        $jsonId = file_get_contents(__DIR__ . '/../providers/wrapper.json');
        $arrJson = json_decode($jsonId, true);
        $newId = $arrJson['id_dato'];
        
        if ($method === 'delete') {            
            $query = str_replace('@id@', $newId, $query);
        }
        
        if ($method === 'all') {
            $this->db = New Db('dbcore');
        } else {
            $this->db = New Db('SPT');
        }
        
        Reflections::invokeMethod($this->db, 'connect');
        Reflections::invokeMethod($this->db, 'query', array($query));
        
        $actual = Reflections::getProperty($this->db, 'pdoStmt');
        
        $this->assertInstanceOf('PDOStatement', $actual); 
        
        if ($method === 'delete') {            
            file_put_contents(__DIR__ . '/../providers/wrapper.json','{"id_dato":' . ($newId + 1) . '}');
        }
    }

    /**
     * @group db
     * @coversNothing
     */
    public function fetchProvider()
    {
        $data = [
            'read no style' => [
                'query' => 'SELECT id_dato AS id, variabile, valore, CONVERT(varchar, data_e_ora, 20) AS data_e_ora, tipo_dato FROM dati_acquisiti WHERE (id_dato = 97047202);',
                'style' => null, 
                'expected' => [
                    0 => [
                        'id' => '97047202',
                        'variabile' => '82025',
                        'valore' => '0',
                        'data_e_ora' => '2018-10-28 01:00:00',
                        'tipo_dato' => '2'
                    ]
                ]
            ],
            'read assoc' => [
                'query' => 'SELECT id_dato AS id, variabile, valore, CONVERT(varchar, data_e_ora, 20) AS data_e_ora, tipo_dato FROM dati_acquisiti WHERE (id_dato = 97047202);',
                'style' => \PDO::FETCH_ASSOC, 
                'expected' => [
                    0 => [
                        'id' => '97047202',
                        'variabile' => '82025',
                        'valore' => '0',
                        'data_e_ora' => '2018-10-28 01:00:00',
                        'tipo_dato' => '2'
                    ]
                ]
            ],
            'read both' => [
                'query' => 'SELECT id_dato AS id, variabile, valore, CONVERT(varchar, data_e_ora, 20) AS data_e_ora, tipo_dato FROM dati_acquisiti WHERE (id_dato = 97047202);',
                'style' => \PDO::FETCH_BOTH, 
                'expected' => [
                    0 => [
                        0 => '97047202',
                        'id' => '97047202',
                        1 => '82025',
                        'variabile' => '82025',
                        2 => '0',
                        'valore' => '0',
                        3 => '2018-10-28 01:00:00',
                        'data_e_ora' => '2018-10-28 01:00:00',
                        4 => '2',
                        'tipo_dato' => '2'
                    ]
                ]
            ],
            'read num' => [
                'query' => 'SELECT id_dato AS id, variabile, valore, CONVERT(varchar, data_e_ora, 20) AS data_e_ora, tipo_dato FROM dati_acquisiti WHERE (id_dato = 97047202);',
                'style' => \PDO::FETCH_NUM, 
                'expected' => [
                    0 => [
                        0 => '97047202',
                        1 => '82025',
                        2 => '0',
                        3 => '2018-10-28 01:00:00',
                        4 => '2'
                    ]
                ]
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group db
     * @covers \vaniacarta74\Crud\Db::fetch
     * @dataProvider fetchProvider
     */
    public function testFetchEquals($query, $style, $expected)
    {
        Reflections::setProperty($this->db, 'query', $query);        
        Reflections::invokeMethod($this->db, 'connect');
        Reflections::invokeMethod($this->db, 'query');
        
        $actual = Reflections::invokeMethod($this->db, 'fetch', array($style));
        
        $this->assertEquals($expected, $actual);
    }
}
