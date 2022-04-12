<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace vaniacarta74\Sourcerer\api;

use vaniacarta74\Sourcerer\api\Error;

/**
 * Description of Sanitizer
 *
 * @author Vania Carta
 */
class Sanitizer
{
    
    /**
     * @param int $type
     * @param string $paramName
     * @param int $filter
     * @param array|int $options
     * @return mixed
     */
    protected function filterInput(int $type, string $paramName, int $filter, int $options) 
    {
        // @codeCoverageIgnoreStart
        return filter_input($type, $paramName, $filter, $options);
        // @codeCoverageIgnoreEnd
    }
    
    /**
     * @param string $paramName
     * @param int $filterRaw
     * @param array|int $optionsRaw
     * @return string
     */
    public function filterGet(string $paramName, ?int $filterRaw = null, ?int $optionsRaw = null) : string
    {
        try {
            $filter = $filterRaw ?? FILTER_DEFAULT;
            $options = $optionsRaw ?? 0;
            $response = $this->filterInput(INPUT_GET, $paramName, $filter, $options);
            if (is_null($response)) {
                throw new \Exception('Parametro ' . $paramName . ' neccessario.');
            } elseif (!$response) {
                throw new \Exception('Filtraggio valore parametro ' . $paramName . ' fallito.');
            } else {
                return $response;
            }        
        } catch (\Throwable $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }
    
    /**
     * @param string $paramName
     * @param int $filterRaw
     * @param array|int $optionsRaw
     * @return string
     */
    public function filterServer(string $paramName, ?int $filterRaw = null, ?int $optionsRaw = null) : string
    {
        try {
            $filter = $filterRaw ?? FILTER_DEFAULT;
            $options = $optionsRaw ?? 0;
            $response = $this->filterInput(INPUT_SERVER, $paramName, $filter, $options);
            if (is_null($response)) {
                throw new \Exception('Parametro ' . $paramName . ' neccessario.');
            } elseif (!$response) {
                throw new \Exception('Filtraggio valore parametro ' . $paramName . ' fallito.');
            } else {
                return $response;
            }        
        } catch (\Throwable $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }
}
