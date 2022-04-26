<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace vaniacarta74\Crud;

use vaniacarta74\Crud\Db;
use vaniacarta74\Crud\Check;

/**
 * Description of Converter
 *
 * @author Vania
 */
class DbWrapper
{
    /**
     * @var array 
     */
    private static $dbToWrap = ['SPT'];
    
    /**
     * @param string $host
     * @param string $dbName
     * @param string/null $driver
     * @return \vaniacarta74\Crud\Db
     * @throws \Exception
     */
    public static function dbBuilder($host, $dbName, $driver = null)
    {
        try {
            if (!is_string($host) || !is_string($dbName)) {
                throw new \Exception('Formato parametri non valido');
            }
            $dbDriver = (isset($driver) && in_array($driver, array('dblib', 'mssql', 'sqlsrv'))) ? $driver : 'dblib';
            if ($host === 'h2') {
                $dbHost = MSSQL_HOST2;
                $dbUser = MSSQL_USER2;
                $dbPassword = MSSQL_PASSWORD2;
            } else {
                $dbHost = MSSQL_HOST;
                $dbUser = MSSQL_USER;
                $dbPassword = MSSQL_PASSWORD;
            }            
            $db = new Db($dbName, $dbDriver, $dbHost, $dbUser, $dbPassword);            
            return $db;
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    } 
    
    /**
     * @param string $host
     * @param string $dbName
     * @param array $query
     * @param array $params
     * @return array
     * @throws \PDOException
     */
    public static function dateTime($host, $dbName, $query, $params)
    {
        try {
            if (!is_string($host) || !is_string($dbName) || !is_array($query) || !is_array($params)) {
                throw new \Exception('Formato parametri non valido');
            }
            $db = self::dbBuilder($host, $dbName);
            $wrappedParams = self::setDateTimeParams($dbName, $params);
            $results = $db->run($query, $wrappedParams);
            $wrappedResults = self::setDateTimeResults($dbName, $query, $results);
            return $wrappedResults;
        } catch (\PDOException $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    } 
    
    /**
     * @param string $dbName
     * @param array $params
     * @return array
     * @throws \Exception
     */
    public static function setDateTimeParams($dbName, $params)
    {
        try {
            if (!is_string($dbName) || !is_array($params)) {
                throw new \Exception('Formato parametri non valido');
            }
            $changed = [];
            $isTimeZoned = in_array($dbName, self::$dbToWrap);
            foreach ($params as $nParam => $param) {
                foreach ($param as $key => $value) {
                    if ($key === 'value') {
                        if (!array_key_exists('check', $param) || !array_key_exists('type', $param['check'])) {
                            throw new \Exception('Struttura array parametri non valida');
                        } elseif ($param['check']['type'] === 'dateTime') {
                            $changed[$nParam][$key] = self::setDateTime('Y-m-d H:i:s', $value, $isTimeZoned, 'Europe/Rome', 'Etc/GMT-1');
                        } else {
                            $changed[$nParam][$key] = $value;
                        }
                    } else {
                        $changed[$nParam][$key] = $value;
                    }
                }
            }
            return $changed;
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }
    
    /**
     * @param string $format
     * @param string $oldDateTime
     * @param bool $isTimeZoned
     * @param string $timeZoneIn
     * @param string $timeZoneOut
     * @return type
     * @throws \Exception
     */
    public static function setDateTime($format, $oldDateTime, $isTimeZoned, $timeZoneIn, $timeZoneOut)
    {
        try {
            if (!is_string($format) || !is_string($oldDateTime) || !is_bool($isTimeZoned) || !is_string($timeZoneIn) || !is_string($timeZoneOut)) {
                throw new \Exception('Formato parametri non valido');
            }
            $dateTime = self::formatDateTime($oldDateTime);
            if ($isTimeZoned) {
                $dateTimeZoneIn = new \DateTimeZone($timeZoneIn);
                $dateTimeZoneOut = new \DateTimeZone($timeZoneOut);
                $newDateTime = \DateTime::createFromFormat($dateTime['format'], $dateTime['value'], $dateTimeZoneIn);
                $newDateTime->setTimezone($dateTimeZoneOut);
            } else {
                $newDateTime = \DateTime::createFromFormat($dateTime['format'], $dateTime['value']);
            }
            $newValue = $newDateTime->format($format);
            return $newValue;
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }
    
    /**
     * @param string $oldDateTime
     * @return array
     * @throws \Exception
     */
    public static function formatDateTime($oldDateTime)
    {
        try {
            if (!is_string($oldDateTime)) {
                throw new \Exception('Formato parametro non valido');
            }
            $format = self::getDateTimeFormat($oldDateTime);
            if ($format === 'd/m/Y' || $format === 'Y-m-d') {
                $dateTime['format'] = $format . ' H:i:s';
                $dateTime['value'] = $oldDateTime . ' 00:00:00';
            } else {
                $dateTime['format'] = $format;
                $dateTime['value'] = str_replace('T', ' ', $oldDateTime);
            }            
            return $dateTime;
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }
    
    /**
     * @param string $value
     * @return string
     * @throws \Exception
     */
    public static function getDateTimeFormat($value)
    {
        try {
            if (!is_string($value)) {
                throw new \Exception('Formato parametro non valido');
            }
            if (Check::isLatinDateTime($value)) {
                $format = 'd/m/Y H:i:s';
            } elseif (Check::isAngloDateTime($value)) {
                $format = 'Y-m-d H:i:s';
            } elseif (Check::isLatinDate($value)) {
                $format = 'd/m/Y';
            } elseif (Check::isAngloDate($value)) {
                $format = 'Y-m-d';
            } else {
                throw new \Exception('Formato data e ora non convertibile');
            }
            return $format;
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }
    
    /**
     * @param string $dbName
     * @param array $query
     * @param array $results
     * @return array
     * @throws \Exception
     */
    public static function setDateTimeResults($dbName, $query, $results)
    {
        try {
            if (!is_string($dbName) || !is_array($query) || !is_array($results)) {
                throw new \Exception('Formato parametri non valido');
            }
            $isTimeZoned = in_array($dbName, self::$dbToWrap);
            $dateTimeFields = self::getDateTimeFields($query);
            $changed = self::changeDateTimeResults($dateTimeFields, $results, $isTimeZoned);
            return $changed;
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }
    
    /**
     * @param array $dateTimeFields
     * @param array $results
     * @param bool $isTimeZoned
     * @return array
     * @throws \Exception
     */
    public static function changeDateTimeResults($dateTimeFields, $results, $isTimeZoned)
    {
        try {
            if (!is_array($dateTimeFields) || !is_array($results) || !is_bool($isTimeZoned)) {
                throw new \Exception('Formato parametri non valido');
            }
            $changed = [];
            foreach ($results as $keyField => $field) {
                if ($keyField === 'records') {
                    foreach ($field as $nRecord => $record) {
                        foreach ($record as $key => $value) {
                            if (in_array($key, $dateTimeFields)) {
                                $changed[$keyField][$nRecord][$key] = self::setDateTime('d/m/Y H:i:s', $value, $isTimeZoned, 'Etc/GMT-1', 'Europe/Rome');
                            } else {
                                $changed[$keyField][$nRecord][$key] = $value;
                            }
                        }
                    }
                } else {
                    $changed[$keyField] = $field;
                }
            }
            return $changed;
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }
    
    /**
     * @param array $query
     * @return array
     * @throws \Exception
     */
    public static function getDateTimeFields($query)
    {
        try {
            if (!is_array($query) || !array_key_exists('type', $query)) {
                throw new \Exception('Formato parametro non valido o mal strutturato');
            }
            $dateTimeFields = [];
            $type = $query['type'];
            if ($type === 'all' || $type === 'list' || $type === 'read') {
                if (array_key_exists('fields', $query)) {
                    $fields = $query['fields'];
                    foreach ($fields as $nField => $field) {
                        if (array_key_exists('type', $field)) {
                            if ($field['type'] === 'dateTime') {
                                if (array_key_exists('alias', $field) && array_key_exists('name', $field)) {
                                    $dateTimeFields[] = isset($field['alias']) ? $field['alias'] : $field['name'];
                                } else {
                                    throw new \Exception('Array query mal strutturato');
                                }
                            }
                        } else {
                            throw new \Exception('Array query mal strutturato');
                        }                                        
                    }
                } else {
                    throw new \Exception('Array query mal strutturato');
                }                
            }
            return $dateTimeFields;
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }
}
