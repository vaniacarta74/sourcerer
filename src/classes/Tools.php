<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace vaniacarta74\Sourcerer\api;

use vaniacarta74\Sourcerer\api\Sanitizer;

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
    public static function convertUrl(string $paramName, Sanitizer $sanitizer) : string
    {
        try {
            $paramValue = $sanitizer->filterGet($paramName);
            $uri = $sanitizer->filterServer('REQUEST_URI');            
           
            if ($paramValue) {
                $self = $sanitizer->filterServer('PHP_SELF');
                $taditional = $self . '?' . $paramName . '=' . $paramValue;        
                $restful = ROOT . 'api/' . $paramValue . '/#';
                $url = str_replace($taditional, $restful, $uri);
            } else {    
                $url = $uri;
            }            
            $response = strtok($url, '#');            
            
            if (!preg_match('/^(.*\/)*$/', $response)) {
                throw new \Exception('Formato url inaspettato');
            } else {
                return $response;
            }
            
        } catch (\Throwable $e) {        
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;        
        }
    }  
}
