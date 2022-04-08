<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace vaniacarta74\Sourcerer\api;

use vaniacarta74\Sourcerer\api\Error;

/**
 * Description of Sanitizer
 *
 * @author Vania
 */
class Sanitizer
{
    /**
     * @param string $var_name
     * @param int $filter
     * @param array|int $options
     * @return mixed
     */
    public static function inputGet(string $var_name, int $filter = FILTER_DEFAULT, array|int $options = 0) : mixed
    {
        try {
            $response = filter_input(INPUT_GET, $var_name, $filter, $options);
            if (is_null($response)) {
                throw new \Exception('Parametro ' . $var_name . ' neccessario.');
            } elseif (!$response) {
                throw new \Exception('Filtraggio valore parametro ' . $var_name . ' fallito.');
            } else {
                return $response;
            }
        } catch (\Throwable $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }
    
    /**
     * @param string $constant_name
     * @param int $filter
     * @param array|int $options
     * @return mixed
     */
    public static function inputServer(string $constant_name, int $filter = FILTER_DEFAULT, array|int $options = 0) : mixed
    {
        try {
            $response = filter_input(INPUT_SERVER, $constant_name, $filter, $options);
            if (is_null($response)) {
                throw new \Exception('Valore $_SERVER[\'' . $constant_name . '\'] non settato.');
            } elseif (!$response) {
                throw new \Exception('Filtraggio valore parametro $_SERVER[\'' . $constant_name . '\'] fallito.');
            } else {
                return $response;
            }
        } catch (\Throwable $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }
}
