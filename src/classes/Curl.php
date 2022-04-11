<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace vaniacarta74\Sourcerer\api;

use vaniacarta74\Sourcerer\api\Error;

/**
 * Description of Curl
 *
 * @author Vania
 */
class Curl
{
    /**
     * @param string $url
     * @param string/null $httpMethod
     * @param array/null $params
     * @param bool/null $json
     * @return string
     * @throws \Throwable
     */    
    public static function run(string $url, ?string $httpMethod = null, ?array $params = null, ?bool $json = null) : string
    {
        try {
            $method = $httpMethod ?? 'GET';
            $isJson = $json ?? false;
            if ($method === 'POST') {
                if (!isset($params) || count($params) === 0) {
                    throw new \Exception('Parametri curl non definiti');
                } else {
                    $ch = self::set($url, $method, $params, $isJson);
                }
            } else {
                $ch = self::set($url, $method);
            }
            $report = self::exec($ch);
            
            return $report;
        } catch (\Throwable $e) {
            Error::printErrorInfo(__FUNCTION__, DEBUG_LEVEL);
            throw $e;
        }
    }
    
    /**
     * @param string $url
     * @param string $method
     * @param array/null $params
     * @param bool/null $json
     * @return resource
     * @throws \Throwable
     */
    public static function set(string $url, string $method, ?array $params = null, ?bool $json = null)
    {
        try {
            if (!in_array($method, array('GET', 'POST', 'PUT', 'PATCH', 'DELETE'))) {
                throw new \Exception('Formato parametri non corretto o valori non ammessi');
            }
            $isJson = $json ?? false;
            $ch = curl_init();            
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, TIMEOUT);
            curl_setopt($ch, CURLOPT_TIMEOUT, TIMEOUT);
            switch ($method) {
                case 'GET':
                    curl_setopt($ch, CURLOPT_HEADER, false);
                    break;
                case 'POST':
                    if (isset($params) && count($params) > 0) {                        
                        if ($isJson) {
                            $posts = json_encode($params);
                            $header = [
                                'Content-Type: application/json',
                                'Content-Length: ' . strlen($posts)
                            ];
                            curl_setopt($ch, CURLINFO_HEADER_OUT, true);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                        } else {
                            $posts = $params;
                            curl_setopt($ch, CURLOPT_HEADER, false);
                        }
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $posts);                    
                    } else {
                        throw new \Exception('Parametri POST non definiti');
                    }
                    break;
                default:
                    curl_setopt($ch, CURLOPT_HEADER, false);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
                    break;                
            }
            return $ch;
        } catch (\Throwable $e) {
            Error::printErrorInfo(__FUNCTION__, DEBUG_LEVEL);
            throw $e;
        }
    }
    
    /**
     * @param resource $ch
     * @return string
     * @throws \Throwable
     */
    public static function exec($ch) : string
    {
        try {
            if (!is_resource($ch) && !($ch instanceof \CurlHandle)) {
                throw new \Exception('Risorsa non definita');
            }
            $report = curl_exec($ch);
            curl_close($ch);
            
            return $report;
        } catch (\Throwable $e) {
            Error::printErrorInfo(__FUNCTION__, DEBUG_LEVEL);
            throw $e;
        }
    }    
}
