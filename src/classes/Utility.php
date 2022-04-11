<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace vaniacarta74\Sourcerer\api;

use vaniacarta74\Sourcerer\api\Error;

/**
 * Description of Utility
 *
 * @author Vania Carta
 */
class Utility
{
    /**
     * Stampa il tempo trascorso da una certa data.
     *
     * Il metodo benchmark() fornisce l'intervallo di tempo intercorso da una
     * certa data. Viene utilizzato per calcolare il tempo di esecuzione della
     * procedura.
     *
     * @param string $strDateTime Data nel formato "YYYY-mm-dd HH:ii:ss.millisec"
     * @return string Intervallo intercorso nel formato "secondi,millisecondi"
     */
    public static function benchmark(string $strDateTime) : string
    {
        try {
            $start = \dateTime::createFromFormat('Y-m-d H:i:s.u', $strDateTime, new \DateTimeZone('Europe/Rome'));
            if (!$start) {
                throw new \Exception('Data inizio benchmark inesistente');
            }
            $end = new \DateTime('NOW', new \DateTimeZone('Europe/Rome'));
            $dateInterval = date_diff($start, $end);            
            if ($dateInterval->h === 0) {
                if ($dateInterval->i === 0) {
                    $interval = substr($dateInterval->format('%s,%F'), 0, -3) . ' sec';
                } else {
                    $interval = $dateInterval->format('%i min e %s sec');
                }
            } else {
                $interval = $dateInterval->format('%h ora, %i min e %s sec');
            }
            return $interval;
        } catch (\Throwable $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }    
    
    /**     
     * @param array|string $functionName
     * @return string
     */
    public static function callback( $functionName, array $params)
    {
        try {
            if (is_callable($functionName)) {
                $result = call_user_func_array($functionName, $params);
            } else {
                throw new \Exception('Funzione inesistente');
            }        
            return $result;
        } catch (\Throwable $e) {        
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;        
        }
    }
}
