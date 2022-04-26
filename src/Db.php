<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace vaniacarta74\Sourcerer;

use vaniacarta74\Sourcerer\Error;
use vaniacarta74\Sourcerer\Utility;

/**
 * Description of Db
 *
 * @author Vania
 */
class Db
{
    private $db;
    private $driver;
    private $host;
    private $user;
    private $password;
    private $dsn;
    private $pdo;
    private $pdoStmt;
    private $queryType;
    private $query;
    private $id;
    
    /**
     * @param string $db
     * @param string $driver
     * @param string $host
     * @param string $user
     * @param string $password
     * @throws \Exception
     */
    public function __construct(string $db, string $driver = null, string $host = null, string $user = null, string $password = null)
    {
        try {
            $this->db = $db;
            $this->driver = isset($driver) ? $driver : 'dblib';
            $this->host = isset($host) ? $host : MSSQL_HOST;
            $this->user = isset($user) ? $user : MSSQL_USER;
            $this->password = isset($password) ? $password : MSSQL_PASSWORD;
            $this->dsn = $this->driver . ':host=' . $this->host . ';dbname=' . $this->db;
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }
    
    /**
     * @param string $host
     * @param string $dbName
     * @param string|null $driver
     * @return \vaniacarta74\Sourcerer\Db
     */
    public static function build(string $host, string $dbName, ?string $driver = null): Db 
    {
        try {
            $dbDriver = (isset($driver) && in_array($driver, array('dblib', 'mssql', 'sqlsrv', 'mysql'))) ? $driver : 'mysql';
            if ($host === 'mysql') {
                $dbHost = MYSQL_HOST;
                $dbUser = MYSQL_USER;
                $dbPassword = MYSQL_PASSWORD;
            } elseif ($host === 'mssql') {
                $dbHost = MSSQL_HOST;
                $dbUser = MSSQL_USER;
                $dbPassword = MSSQL_PASSWORD;
            } else {
                $dbHost = MYSQL_HOST;
                $dbUser = MYSQL_USER;
                $dbPassword = MYSQL_PASSWORD;
            }            
            $db = new Db($dbName, $dbDriver, $dbHost, $dbUser, $dbPassword);            
            return $db;
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }
    
    /**
     * @param array $queryParams
     * @param array $bindParams
     * @return array
     * @throws \PDOException
     */
    public function run($queryParams, $bindParams)
    {
        try {
            if (!is_array($queryParams) || !is_array($bindParams)) {
                throw new \PDOException('Formato parametri non valido');
            }
            $this->connect();
            $this->assemble($queryParams);
            $this->prepare();
            $this->setId($bindParams);
            $this->bind($bindParams);
            $this->exec();
            return $this->getResults();
        } catch (\PDOException $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }
      
    /**
     * 
     * @throws \PDOException
     */
    public function connect()
    {
        try {
            $n = 5;
            $delay = 500000;
            $params = [
                'db' => $this->db,
                'driver' => $this->driver,
                'host' => $this->host,
                'user' => $this->user,
                'password' => $this->password
            ];
            $key = md5(serialize($params));    
            if (!array_key_exists($key, $GLOBALS) || !($GLOBALS[$key] instanceof \PDO)) {
                $isOk = false;
                for ($i = 1; $i <= $n; $i++) {
                    try {
                        $pdo = new \PDO($this->dsn, $this->user, $this->password);
                        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                        $GLOBALS[$key] = $pdo;
                        $isOk = true;
                        break;
                    } catch (\PDOException $e) {
                        usleep($delay);
                        continue;
                    }
                }
                if (!$isOk) {
                    throw new \PDOException('Impossibile stabilire la seguente connessione: dsn = ' . $this->dsn);
                }
            }
            $this->pdo = $GLOBALS[$key];
        } catch (\PDOException $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }
    
    /**
     * @param array $queryParams
     * @throws \PDOException
     */
    public function assemble($queryParams)
    {
        try {
            if (!is_array($queryParams) || !array_key_exists('type', $queryParams) || !in_array($queryParams['type'], array('all', 'read', 'list', 'create', 'update', 'delete'))) {
                throw new \PDOException('Formato parametri, struttura o tipo elaborazione non valida');
            }
            $this->queryType = $queryParams['type'];
            $method = 'prepare' . ucfirst($this->queryType);
            $rawQuery = $this->$method($queryParams);
            $this->query = $rawQuery;
        } catch (\PDOException $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }
    
    /**
     * @throws \PDOException
     */
    public function prepare()
    {
        try {
            if (is_string($this->query)) {
                $this->pdoStmt = $this->pdo->prepare($this->query);
            } else {
                throw new \PDOException('Formato query non valido: usare string');
            }
        } catch (\PDOException $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }
    
    /**
     * @param array $queryParams
     * @return string
     * @throws \Exception
     */
    private function prepareList($queryParams)
    {
        try {
            if (!is_array($queryParams) || !array_key_exists('fields', $queryParams) || !array_key_exists('table', $queryParams) || !array_key_exists('where', $queryParams) || !array_key_exists('order', $queryParams)) {
                throw new \Exception('Formato parametri, struttura o tipo elaborazione non valida');
            }
            $fields = $this->setSelectFields($queryParams['fields']);
            $table = $this->setTable($queryParams['table']);
            $where = $this->setWhere($queryParams['where']);
            $order = $this->setOrder($queryParams['order']);
            
            $rawQuery = 'SELECT ' . $fields . ' FROM ' . $table . (isset($where) ? ' WHERE ' . $where : null) . (isset($order) ? ' ORDER BY ' . $order : null) . ';';
            
            return $rawQuery;
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }
    
    /**
     * @param array $queryParams
     * @return string
     * @throws \Exception
     */
    private function prepareRead($queryParams)
    {
        try {
            if (!is_array($queryParams) || !array_key_exists('fields', $queryParams) || !array_key_exists('table', $queryParams) || !array_key_exists('where', $queryParams) || !array_key_exists('order', $queryParams)) {
                throw new \Exception('Formato parametri, struttura o tipo elaborazione non valida');
            }
            $fields = $this->setSelectFields($queryParams['fields']);
            $table = $this->setTable($queryParams['table']);
            $where = $this->setWhere($queryParams['where']);
            $order = $this->setOrder($queryParams['order']);
            
            $rawQuery = 'SELECT ' . $fields . ' FROM ' . $table . (isset($where) ? ' WHERE ' . $where : null) . (isset($order) ? ' ORDER BY ' . $order : null) . ';';
            
            return $rawQuery;
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }
    
    /**
     * @param array $queryParams
     * @return string
     * @throws \Exception
     */
    private function prepareAll($queryParams)
    {
        try {
            if (!is_array($queryParams) || !array_key_exists('fields', $queryParams) || !array_key_exists('table', $queryParams) || !array_key_exists('order', $queryParams)) {
                throw new \Exception('Formato parametri, struttura o tipo elaborazione non valida');
            }
            $fields = $this->setSelectFields($queryParams['fields']);
            $table = $this->setTable($queryParams['table']);
            $order = $this->setOrder($queryParams['order']);
            
            $rawQuery = 'SELECT ' . $fields . ' FROM ' . $table . (isset($order) ? ' ORDER BY ' . $order : null) . ';';
            
            return $rawQuery;
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }
    
    /**
     * @param array $queryParams
     * @return string
     * @throws \Exception
     */
    private function prepareCreate($queryParams)
    {
        try {
            if (!is_array($queryParams) || !array_key_exists('table', $queryParams) || !array_key_exists('values', $queryParams)) {
                throw new \Exception('Formato parametri, struttura o tipo elaborazione non valida');
            }
            $table = $this->setTable($queryParams['table']);
            $fields = $this->setInsertFields($queryParams['values']);
            $values = $this->setValues($queryParams['values']);
            
            $rawQuery = 'INSERT INTO ' . $table . ' (' . $fields . ') VALUES (' . $values . ');';
            
            return $rawQuery;
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }
    
    /**
     * @param array $queryParams
     * @return string
     * @throws \Exception
     */
    private function prepareUpdate($queryParams)
    {
        try {
            if (!is_array($queryParams) || !array_key_exists('table', $queryParams) || !array_key_exists('set', $queryParams) || !array_key_exists('where', $queryParams)) {
                throw new \Exception('Formato parametri, struttura o tipo elaborazione non valida');
            }
            $table = $this->setTable($queryParams['table']);
            $sets = $this->setSets($queryParams['set']);
            $where = $this->setWhere($queryParams['where']);
            
            $rawQuery = 'UPDATE ' . $table . ' SET ' . $sets . ' WHERE ' . $where . ';';
            
            return $rawQuery;
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }
    
    /**
     * @param array $queryParams
     * @return string
     * @throws \Exception
     */
    private function prepareDelete($queryParams)
    {
        try {
            if (!is_array($queryParams) || !array_key_exists('table', $queryParams) || !array_key_exists('where', $queryParams)) {
                throw new \Exception('Formato parametri, struttura o tipo elaborazione non valida');
            }
            $table = $this->setTable($queryParams['table']);
            $where = $this->setWhere($queryParams['where']);
            
            $rawQuery = 'DELETE FROM ' . $table . ' WHERE ' . $where . ';';
            
            return $rawQuery;
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }
    
    /**
     * @param array $arrFields
     * @return string
     * @throws \Exception
     */
    private function setSelectFields($arrFields)
    {
        try {
            if (!is_array($arrFields)) {
                throw new \Exception('Formato parametro non valido');
            }
            $strFields = [];
            foreach ($arrFields as $field) {
                if (array_key_exists('name', $field)) {
                    if (isset($field['alias'])) {
                        $strFields[] = $field['name'] . ' AS ' . $field['alias'];
                    } else {
                        $strFields[] = $field['name'];
                    }
                } else {
                    throw new \PDOException('Struttura array non valida: richiesta chiave "name"');
                }
            }
            if (count($strFields) === 0) {
                $fields = '*';
            } else {
                $fields = implode(', ', $strFields);
            }
            return $fields;
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }
    
    /**
     * @param string $table
     * @return string
     * @throws \Exception
     */
    private function setTable($table)
    {
        try {
            if (!is_string($table)) {
                throw new \Exception('Formato parametro non valido');
            }
            return $table;
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }
    
    /**
     * @param array $arrWhere
     * @return string/null
     * @throws \Exception
     */
    private function setWhere($arrWhere)
    {
        try {
            if (!is_array($arrWhere)) {
                throw new \Exception('Formato parametro non valido');
            }
            if (count($arrWhere) > 0) {                
                $keys = array_keys($arrWhere);
                if (preg_match('/^(and|or)(.)*$/', $keys[0], $match)) {
                    $opAndOr = strtoupper($match[1]); 
                    $subExp = $this->setWhereRecursive($arrWhere);
                    $where = implode(' ' . $opAndOr . ' ', $subExp);
                } else {
                    throw new \Exception('La prima chiave dell\'array where deve essere and o or');
                }
            } else {            
                $where = null;
            }
            return $where;
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }
    
    /**
     * @param array $params
     * @return array
     * @throws \Exception
     */
    private function setWhereRecursive($params) 
    {
        try {
            if (!is_array($params)) {
                throw new \Exception('Tipo parametro errato usare array');
            }
            foreach ($params as $key => $param) {
                if (preg_match('/^(and|or)(.)*$/', $key, $match)) {
                    $opAndOr = strtoupper($match[1]);
                    $subExp = $this->setWhereRecursive($param);                                        
                    $exp[] = '(' . implode(' ' . $opAndOr . ' ', $subExp) . ')';
                } else {
                    if (array_key_exists('field', $param) && array_key_exists('operator', $param) && array_key_exists('value', $param) && array_key_exists('bind', $param['value'])) {
                        $exp[] =  $param['field'] . ' ' . $param['operator'] . ' ' . $param['value']['bind']; 
                    } else {
                        throw new \Exception('Struttura array where non corretta');
                    }
                }
            }
            return $exp;
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }        
    }
    
    /**
     * @param array $arrOrders
     * @return string/null
     * @throws \Exception
     */
    private function setOrder($arrOrders)
    {
        try {
            if (!is_array($arrOrders)) {
                throw new \Exception('Tipo parametro errato usare array');
            }
            $strOrders = [];
            foreach ($arrOrders as $order) {
                if (array_key_exists('field', $order) && array_key_exists('type', $order)) {
                    $strOrders[] = $order['field'] . ' ' . strtoupper($order['type']); 
                } else {
                    throw new \Exception('Struttura array order non corretta');
                }
            }
            if (count($strOrders) === 0) {
                $orders = null;
            } else {
                $orders = implode(', ', $strOrders);
            }
            return $orders;
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }   
    
    /**
     * 
     * @param array $arrValues
     * @return string
     * @throws \Exception
     */
    private function setInsertFields($arrValues)
    {
        try {
            if (!is_array($arrValues)) {
                throw new \Exception('Tipo parametro errato usare array');
            }
            $strFields = [];
            foreach ($arrValues as $params) { 
                if (array_key_exists('field', $params)) {
                    $strFields[] = $params['field'];
                } else {
                    throw new \Exception('Struttura array values non corretta');
                }
            }
            $fields = implode(', ', $strFields);
            return $fields;
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }
    
    /**
     * @param array $arrValues
     * @return string
     * @throws \Exception
     */
    private function setValues($arrValues)
    {
        try {
            if (!is_array($arrValues)) {
                throw new \Exception('Tipo parametro errato usare array');
            }
            $strValues = [];
            foreach ($arrValues as $params) {
                if (array_key_exists('value', $params) && array_key_exists('bind', $params['value'])) {
                    $strValues[] = $params['value']['bind'];
                } else {
                    throw new \Exception('Struttura array values non corretta');
                }
            }
            $values = implode(', ', $strValues);
            return $values;
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }
    
    /**
     * @param array $arrSets
     * @return string
     * @throws \Exception
     */
    private function setSets($arrSets)
    {
        try {
            if (!is_array($arrSets)) {
                throw new \Exception('Tipo parametro errato usare array');
            }
            $strSets = [];
            foreach ($arrSets as $params) { 
                if (array_key_exists('field', $params) && array_key_exists('value', $params) && array_key_exists('bind', $params['value'])) {
                    $strSets[] = $params['field'] . ' = ' . $params['value']['bind'];
                } else {
                    throw new \Exception('Struttura array set non corretta');
                }
            }
            $sets = implode(', ', $strSets);
            return $sets;
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }
    
    /**
     * @return bool
     * @throws \PDOException
     */
    public function exec()
    {
        try {
            return $this->pdoStmt->execute();
        // @codeCoverageIgnoreStart
        } catch (\PDOException $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
        // @codeCoverageIgnoreEnd
    }
    
    /**
     * @param array $bindParams
     * @return boolean
     * @throws \PDOException
     */
    public function bind($bindParams)
    {
        try {
            if (!is_array($bindParams)) {
                throw new \PDOException('Tipo parametro errato usare array');
            }
            $isOk = true;
            foreach ($bindParams as $param) {
                if (array_key_exists('type', $param) && (in_array($param['type'], array('str', 'int', 'bool', 'null'))) && array_key_exists('bind', $param) && array_key_exists('value', $param)) {
                    $type = constant('\PDO::PARAM_' . strtoupper($param['type']));
                    if (!$this->pdoStmt->bindParam($param['bind'], $param['value'], $type)) {
                    // @codeCoverageIgnoreStart
                        $isOk = false;                        
                    }
                    // @codeCoverageIgnoreEnd
                } else {
                    throw new \PDOException('Struttura array bind params non corretta');
                }
            }
            return $isOk;
        } catch (\PDOException $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }
    
    /**
     * @param array $bindParams
     * @throws \Exception
     */
    public function setId($bindParams)
    {
        try {
            if (!is_array($bindParams)) {
                throw new \Exception('Tipo parametro errato usare array');
            }
            foreach ($bindParams as $param) {
                if (array_key_exists('param', $param)) {
                    if ($param['param'] === 'id') {
                        if (array_key_exists('value', $param)) {
                            $this->id = $param['value'];
                            break;
                        } else {
                            throw new \Exception('Struttura array bind params non corretta');
                        }
                    }
                } else {
                    throw new \Exception('Struttura array bind params non corretta');
                }
            }
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }
    
    /**
     * @param string $query
     * @return array
     * @throws \PDOException
     */
    public function go($query)
    {
        try {
            if (!is_string($query)) {
                throw new \PDOException('Tipo parametro errato usare string');
            }
            $this->checkQuery($query);            
            $this->connect();
            $this->query();
            return $this->getResults();
        } catch (\PDOException $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }
    
    /**
     * @param string $query
     * @throws \Exception
     */
    public function checkQuery($query)
    {
        try {
            if (!is_string($query)) {
                throw new \Exception('Tipo parametro errato usare string');
            }
            if (preg_match('/^(SELECT|INSERT|UPDATE|DELETE)(.)*$/', $query, $match)) {
                switch ($match[1]) {
                    case 'SELECT':
                        $type = 'list';
                        break;
                    case 'INSERT':
                        $type = 'create';
                        break;
                    case 'UPDATE':
                        $type = 'update';
                        break;
                    case 'DELETE':
                        $type = 'delete';
                        break;
                }
            } else {
                throw new \Exception('Query non regolare');
            }            
            $this->queryType = $type;
            $this->query = $query;
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }
    
    public function query()
    {
        try {
            $this->pdoStmt = $this->pdo->query($this->query);
        // @codeCoverageIgnoreStart            
        } catch (\PDOException $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
        // @codeCoverageIgnoreEnd
    }   
    
    /**
     * @return array
     * @throws \PDOException
     */
    private function getResults()
    {
        try {
            $response['type'] = $this->queryType;
            if ($this->queryType === 'list' || $this->queryType === 'read' || $this->queryType === 'all') {
                $response['records'] = $this->fetch();
            } elseif ($this->queryType === 'create') {
                $this->id = $this->pdo->lastInsertId();
                $response['records'] = [];
            } else {
                $response['records'] = [];
            }
            $response['id'] = isset($this->id) ? $this->id : null;
            return $response;
        // @codeCoverageIgnoreStart
        } catch (\PDOException $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
        // @codeCoverageIgnoreEnd
    }
    
    /**
     * @param obj $style
     * @return array
     * @throws \PDOException
     */
    public function fetch($style = null)
    {
        try {
            if (isset($style) && in_array($style, array(\PDO::FETCH_ASSOC, \PDO::FETCH_BOTH, \PDO::FETCH_NUM))) {
                $pdoStyle = $style;
            } else {
                $pdoStyle = \PDO::FETCH_ASSOC;
            }            
            while ($row = $this->pdoStmt->fetch($pdoStyle)) {
                $records[] = $row;
            }            
            return $records;
        // @codeCoverageIgnoreStart
        } catch (\PDOException $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
        // @codeCoverageIgnoreEnd
    }
}
