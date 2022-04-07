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
    protected $file;
        
    /**
     * @param string $path
     * @throws \Exception
     */
    public function __construct(string $path)
    {
        try {            
            $this->setFile($path, ROUTES);
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
    private function setFile(string $path, array $routes)
    {
        try {
            $isOk = false;
            foreach ($routes as $file => $route) {
                if (strpos($path, $file) !== false) {
                    $this->file = $route['path'];
                    $isOk = true;
                    break;
                }
            }
            if ($isOk) {
                return $isOk;
            } else {
                throw new \Exception('Nome file non trovato.');
            }        
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }   
}
