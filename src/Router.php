<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace vaniacarta74\Sourcerer;

use vaniacarta74\Sourcerer\Accessor;
use vaniacarta74\Sourcerer\Error;

/**
 * Description of Router
 *
 * @author Vania
 */
class Router extends Accessor
{
    protected $input;
    protected $host;
    protected $db;
    protected $alias;
    protected $table;
    protected $resource;
    protected $id;
    protected $queryType;
    protected $queryParams;
    protected $urlParams;
    
    /**
     * @param string $path
     * @param string $method
     * @param string $input
     * @throws \Exception
     */
    public function __construct($path, $method, $input = null)
    {
        try {
            $this->setInput($input);            
            $strJson = @file_get_contents(__DIR__ . '/json/routes.json');
            $routes = json_decode($strJson, true);
            $this->setHost($path);
            $this->setDb($path, $routes);
            $this->setTable($path, $routes);
            $this->setResource();
            $this->setId($path);
            $this->setQueryType($method);
            $this->setQueryParams();
            $this->setUrlParams();
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }
    
    /**
     * @param string $phpInput
     * @throws \Exception
     */
    private function setInput($phpInput)
    {
        try {
            if (count($_GET) > 0) {
                $input = $_GET;
            } elseif (count($_POST) > 0) {
                $input = $_POST;
            } else {
                if (isset($phpInput)) {
                    if (file_exists($phpInput)) {
                        $post = @file_get_contents($phpInput);
                    } else {
                        throw new \Exception('File inesistente');
                    }                    
                } else {
                    $post = @file_get_contents('php://input');
                }
                $input = $post ? json_decode($post, true) : null;
            }
            $this->input = $input;
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }
    
    /**
     * @param string $path
     * @throws \Exception
     */
    private function setHost($path)
    {
        try {
            if (!is_string($path)) {
                throw new \Exception('Formato parametro non corretto');
            }
            if (strpos($path, 'h1')) {
                $host = 'h1';
            } elseif (strpos($path, 'h2')) {
                $host = 'h2';
            } else {
                throw new \Exception('Host non definito');
            }
            $this->host = $host;                    
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }
    
    /**
     * @param string $path
     * @param array $routes
     * @return boolean
     * @throws \Exception
     */
    private function setDb($path, $routes)
    {
        try {
            $isOk = false;
            foreach ($routes as $db => $route) {
                if (strpos($path, $route['alias']) !== false) {
                    $this->db = $db;
                    $this->alias = $route['alias'];
                    $isOk = true;
                    break;
                }
            }
            if ($isOk) {
                return $isOk;
            } else {
                throw new \Exception('Nome db non trovato.');
            }        
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }    
    
    /**
     * @param string $path
     * @param array $routes
     * @return boolean
     * @throws \Exception
     */
    private function setTable($path, $routes)
    {
        try {
            $tables = $routes[$this->db]['tables'];
            $isOk = false;
            foreach ($tables as $table) {
                if (strpos($path, $table) !== false) {
                    $this->table = $table;
                    $isOk = true;
                    break;
                }
            }
            if ($isOk) {
                return $isOk;
            } else {
                throw new \Exception('Nome tabella non trovato.');
            }        
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }
    
    /**
     * @throws \Exception
     */
    private function setResource()
    {
        try {
            if (isset($this->host) && isset($this->alias) && isset($this->table)) {
                $resource = '/' . $this->host . '/' . $this->alias . '/' . $this->table;
            } else {
                throw new \Exception('Risorsa non definibile.');
            }
            $this->resource = $resource;        
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }
    
    /**
     * @param string $path
     * @throws \Exception
     */
    private function setId($path)
    {
        try {
            $baseRegex = $this->host . '\/' . $this->alias . '\/' . $this->table;
            if (preg_match('/' . $baseRegex  . '$/', $path)) {
                $this->id = null;
            } elseif (preg_match('/' . $baseRegex  . '\/(all|ALL|[0-9]+)$/', $path, $matches)) {
                $this->id = $matches[1];
            } else {
                throw new \Exception('Id non definito correttamente.');
            }
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }
    
    /**
     * @param string $method
     * @throws \Exception
     */
    private function setQueryType($method)
    {
        try {
            $queryType = '';
            if (isset($this->id)) {
                switch ($method) {
                    case 'GET':
                        $queryType = (strtoupper($this->id) === 'ALL') ? 'all' : 'read';
                        break;
                    case 'PUT':
                    case 'PATCH':
                        $queryType = 'update';
                        break;
                    case 'DELETE':
                        $queryType = 'delete';
                        break;
                }
            } else {
                switch ($method) {
                    case 'GET':
                        $queryType = 'list';
                        break;
                    case 'POST':
                        $queryType = 'create';
                        break;
                }
            }
            if ($queryType !== '') {
                $this->queryType = $queryType;
            } else {
                throw new \Exception('Parametri richiesta errati.');
            }           
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }
    
    /**
     * @throws \Exception
     */
    private function setQueryParams()
    {
        try {
            $path = __DIR__ . '/json/' . $this->table . '.json';
            if (!file_exists($path)) {
                throw new \Exception('File parametri query non definito');
            }
            $strJson = @file_get_contents($path);
            $params = json_decode($strJson, true);
            if (array_key_exists($this->queryType, $params)) {
                $queryParams = $params[$this->queryType];
                $queryParams['type'] = $this->queryType;
                $this->queryParams = $queryParams;
            } else {
                throw new \Exception('Metodo HTTP non definito per questa tabella');
            }
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }
    
    /**
     * @throws \Exception
     */
    private function setUrlParams()
    {
        try {
            $urlParams = [];
            switch ($this->queryType) {
                case 'list':
                case 'create':
                    $urlParams = $this->input;
                    //$urlParams = $_GET;
                    break;
                case 'all':                   
                case 'read':
                case 'delete':
                    $urlParams['id'] = $this->id;
                    break;
                case 'update':
                    $urlParams = $this->input;
                    $urlParams['id'] = $this->id;
                    break;
            }
            if (count($urlParams) > 0) {
                $this->urlParams = $urlParams;
            } else {
                throw new \Exception('Parametri url non presenti');
            }
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }
}
