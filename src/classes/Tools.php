<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace vaniacarta74\Sourcerer\api;

//use vaniacarta74\Sourcerer\api\Sanitizer;

/**
 * Description of Tools
 *
 * @author adm-gfattori
 */
class Tools {
    
    /**     
     * @param string $paramName
     * @return string
     */
    public static function convertUrl(string $paramName) : string
    {
        try {
            $paramValue = filter_input(INPUT_GET, $paramName);
            $uri = filter_input(INPUT_SERVER, 'REQUEST_URI');
            $self = filter_input(INPUT_SERVER, 'PHP_SELF');
            
            if ($paramValue) {        
                $taditional = $self . '?' . $paramName . '=' . $paramValue;        
                $restful = 'api/' . $paramValue . '/#';
                $url = str_replace($taditional, $restful, $uri);
            } else {    
                $url = $uri;
            }
            return strtok($url, '#');
            
        } catch (\Throwable $e) {        
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;        
        }
    }  
}
