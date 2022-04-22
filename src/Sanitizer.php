<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace vaniacarta74\Sourcerer;

use vaniacarta74\Sourcerer\Error;

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
    protected function filterInput(int $type, string $paramName, int $filter, array|int $options): mixed
    {
        // @codeCoverageIgnoreStart
        return filter_input($type, $paramName, $filter, $options);
        // @codeCoverageIgnoreEnd
    }

    /**
     * @param string $paramName
     * @param int|null $filterRaw
     * @param array|int|null $optionsRaw
     * @return string|null
     * @throws \Exception
     */
    public function filterGet(string $paramName, ?int $filterRaw = null, array|int|null $optionsRaw = null): ?string
    {
        try {
            $filter = $filterRaw ?? FILTER_DEFAULT;
            $options = $optionsRaw ?? 0;
            $response = $this->filterInput(INPUT_GET, $paramName, $filter, $options);
            if (is_null($response)) {
                return null;
            } elseif (!$response) {
                throw new \Exception('Filtraggio valore parametro ' . $paramName . ' fallito.');
            } else {
                return (string)$response;
            }
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }

    /**
     * @param string $paramName
     * @param int|null $filterRaw
     * @param array|int|null $optionsRaw
     * @return string
     * @throws \Exception
     */
    public function filterServer(string $paramName, ?int $filterRaw = null, array|int|null $optionsRaw = null): string
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
                return (string)$response;
            }
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }
}
