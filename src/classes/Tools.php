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
    public static function convertUrl(string $paramName) : string
    {
        try {
            $sanitizer = new Sanitizer();
            $paramValue = $sanitizer->filterGet($paramName);
            $uri = $sanitizer->filterServer('REQUEST_URI');
            $self = $sanitizer->filterServer('PHP_SELF');
            
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
