<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace vaniacarta74\Sourcerer\api;

use vaniacarta74\Sourcerer\api\Error;

/**
 * Description of Validator
 *
 * @author Vania Carta
 */
class Validator
{
    /**
     * @param string $var_name
     * @return mixed
     */
    public static function validateHostName(mixed $var_name) : mixed
    {
        try {
            $response = filter_var($var_name, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME);
            if (!$response) {
                throw new \Exception('Validazione nome Host ' . $var_name . ' fallito.');
            } else {
                return $response;
            }
        } catch (\Throwable $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }
    
    /**
     * @param string $var_name
     * @return mixed
     */
    public static function validateIPv4(mixed $var_name) : mixed
    {
        try {
            $response = filter_var($var_name, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
            if (!$response) {
                throw new \Exception('Validazione IPv4 ' . $var_name . ' fallito.');
            } else {
                return $response;
            }
        } catch (\Throwable $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }
}
