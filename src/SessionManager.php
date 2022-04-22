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
 * Description of class
 *
 * @author Vania Carta
 */
class SessionManager extends Accessor implements \SessionHandlerInterface
{
    private const SESSION_SAVE_PATH = '/var/www/html/tmp';
    private const SESSION_LIFE_TIME = 3600;

    private $sessionName;
    /**
     * @param string|null $savePath
     * @param int|null $sessionLifetime
     */
    public function __construct(
        private ?string $savePath = self::SESSION_SAVE_PATH,
        private ?int $sessionLifetime = self::SESSION_LIFE_TIME
    ) {
        try {
            ini_set('session.save_handler', 'files');
            session_save_path($savePath);
            session_set_cookie_params($sessionLifetime);
            session_set_save_handler($this, true);
            session_start();
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }

    /**
     * @param string $savePath
     * @param string $sessionName
     * @return boolean
     */
    public function open(string $savePath, string $sessionName): bool
    {
        try {
            $this->savePath = $savePath;
            $this->sessionName = $sessionName;
            if (!is_dir($savePath)) {
                mkdir($savePath, 0777);
            }
            return true;
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }

    /**
     * @param string $id
     * @return string|false
     */
    public function read(string $id): string|false
    {
        try {
            $file = $this->savePath . '/sess_' . $id;
            if (!file_exists($file)) {
                fopen($file, 'w+');
            }
            return file_get_contents($file);
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }

    /**
     * @param string $id
     * @param string $data
     * @return boolean
     */
    public function write(string $id, string $data): bool
    {
        try {
            $file = $this->savePath . '/sess_' . $id;
            $boolean = file_put_contents($file, $data) === false ? false : true;
            return $boolean;
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }

    /**
     * @param string $id
     * @return boolean
     */
    public function destroy(string $id): bool
    {
        try {
            $file = $this->savePath . '/sess_' . $id;
            if (file_exists($file)) {
                unlink($file);
            }
            return true;
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }

    /**
     * @return boolean
     */
    public function close(): bool
    {
        try {
            $this->gc($this->sessionLifetime);
            return true;
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }

    /**
     * @param int $maxlifetime
     * @return int|boolean
     * @throws \Exception
     */
    public function gc(int $maxlifetime): int|false
    {
        try {
            $isOk = true;
            $counter = 0;
            $filePattern = $this->savePath . '/sess_*';
            foreach (glob($filePattern) as $file) {
                if (filemtime($file) + $maxlifetime < time() && file_exists($file)) {
                    unlink($file) ? $counter++ : $isOk = false;
                }
            }
            $response = $isOk ? $counter : false;
            return $response;
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }
}
