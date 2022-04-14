<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace vaniacarta74\Sourcerer\api;

use vaniacarta74\Sourcerer\api\Accessor;
use vaniacarta74\Sourcerer\api\Error;

/**
 * Description of Router
 *
 * @author Vania Carta
 */
class Router extends Accessor
{
    protected $route;

    /**
     * @param string $resource
     * @throws \Exception
     */
    public function __construct(string $resource)
    {
        try {
            $this->setRoute($resource, ROUTES);
            // @codeCoverageIgnoreStart
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
        // @codeCoverageIgnoreEnd
    }

    /**
     * @param string $resource
     * @param array $routes
     * @return boolean
     * @throws \Exception
     */
    private function setRoute(string $resource, array $routes): bool
    {
        try {
            $isOk = false;
            foreach ($routes as $routeName => $attributes) {
                if (strpos($resource, $routeName) !== false) {
                    $this->route = $attributes['route'];
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
