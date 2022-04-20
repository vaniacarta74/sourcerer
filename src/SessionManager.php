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

    private $phpSessionId;
    private $id;
//    private $idSessione;
//    private $idUtente;
//    private $isLogged;
//    private $dataCreazione;
//    private $dataAggiornamento;
//    private $browser;
//    private $root;
    private $sessionLifetime = 3600;
//    private $sessionTimeout = 600;
    private $savePath;
    private $sessionName;
    public $session = array();

    /**
     * @return void
     * @throws \Exception
     */
    public function __construct()
    {
        try {
            ini_set('session.save_handler', 'files');
            session_save_path("/var/www/html/tmp");
            session_set_save_handler($this, true);
            session_set_cookie_params($this->sessionLifetime);
            session_start();
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }
    
    /**
     * @return void
     * @throws \Exception
     */
//    public function forceLogIn(): void
//    {
//        try {            
//            $this->isLogged = 1;
//        } catch (\Exception $e) {
//            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
//            throw $e;
//        }
//    }
    
    /**
     * @param string $savePath
     * @param string $sessionName
     * @return boolean
     * @throws \Exception
     */
    public function open(string $savePath, string $sessionName): bool
    {
        try {            
            $this->savePath = $savePath;
            $this->sessionName = $sessionName;
            if (!is_dir($this->savePath)) {
                mkdir($this->savePath, 0777);
            }
            $this->id = session_id();
            fopen($this->savePath . '/sess_' . $this->id, 'w+');
        //DataManager::dbOpen();        
            return true;
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }        
    }
    
    /**
     * @return boolean
     * @throws \Exception
     */
    public function close(): bool {
        try {
            $this->gc($this->sessionLifetime);
            //DataManager::dbClose();
            return true;
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }        
    }
    
    /**
     * @param string $id
     * @return string|false
     * @throws \Exception
     */
    public function read(string $id): string|false
    {
        try {
//        $sql = 'SELECT id_sessione, n_sessione, utente, logged, creazione, aggiornamento, browser FROM sessioni WHERE n_sessione = "' . $id . '"';
//        $rows = DataManager::dbQuery($sql);
//        if (!empty($rows)) {
//            $this->phpSessionId = $rows[0]['n_sessione'];
//            $this->idSessione = $rows[0]['id_sessione'];
//            $this->idUtente = $rows[0]['utente'];
//            $this->isLogged = $rows[0]['logged'];
//            $this->dataCreazione = $rows[0]['creazione'];
//            $this->dataAggiornamento = $rows[0]['aggiornamento'];
//            $this->browser = $rows[0]['browser'];
//            $sql = 'SELECT nome, valore FROM variabili WHERE sessione = ' . $this->idSessione;
//            $rows = DataManager::dbQuery($sql);            
//            if (!empty($rows)) {                
//                foreach ($rows as $row) {                    
//                    $this->session[$row['nome']] = unserialize($row['valore']);
//                }
//            }
//            if ($this->isLogged) {
//                $sql = 'SELECT root FROM utenti WHERE id_utente = ' . $this->idUtente;
//                $rows = DataManager::dbQuery($sql);
//                $this->root = $rows[0]['root'];
//            } else {
//                $this->root = "";
//            }
//        } else {
//            $this->phpSessionId = $id;
//            $this->idUtente = 1;
//            $this->isLogged = 0;
//            $this->browser = $_SERVER['HTTP_USER_AGENT'];
//        }
            $this->phpSessionId = $id;
            //$string = @file_get_contents($this->savePath . '/sess_' . $id);
            $string = file_get_contents($this->savePath . '/sess_' . $id);
            return $string;
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }
    
    /**
     * @param string $id
     * @param string $data
     * @return boolean
     * @throws \Exception
     */
    public function write(string $id, string $data): bool
    {
        try {
//        $sql = 'SELECT id_sessione FROM sessioni WHERE n_sessione = "' . $id . '"';
//        $rows = DataManager::dbQuery($sql);
//        if (!empty($rows)) {
//            $idSessione = $rows[0]['id_sessione'];
//            $sql = 'DELETE FROM variabili WHERE sessione = ' . $idSessione; 
//            DataManager::dbQuery($sql);
//            $sql = 'UPDATE sessioni SET utente = ' . $this->idUtente . ', logged = ' . $this->isLogged . ', aggiornamento = NOW(), browser = "' . $this->browser . '" WHERE n_sessione = "' . $id . '"';
//            DataManager::dbQuery($sql);
//        } else {
//            $sql = 'INSERT INTO sessioni (n_sessione, utente, logged, creazione, aggiornamento, browser) VALUES ("' . $id . '", ' . $this->idUtente . ', ' . $this->isLogged . ', NOW(), NOW(), "' . $this->browser . '")';
//            DataManager::dbQuery($sql);
//            $sql = 'SELECT id_sessione FROM sessioni WHERE n_sessione = "' . $id . '"';
//            $rows = DataManager::dbQuery($sql);
//            $idSessione = $rows[0]['id_sessione'];
//        }        
//        foreach ($this->session as $key => $value) {
//            $sql = 'INSERT INTO variabili (sessione, nome, valore) VALUES (' . $idSessione . ', "' . $key . '", "' . str_replace('"', '\"', serialize($value)) . '")';
//            DataManager::dbQuery($sql);                
//        }
            $this->session[] = $data;
            $boolean = file_put_contents($this->savePath . '/sess_' . $id, $data, FILE_APPEND) === false ? false : true; 
            return $boolean;
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }
    
    /**
     * @param string $id
     * @return boolean
     * @throws \Exception
     */
    public function destroy(string $id): bool
    {
        try {
//        $sql = 'SELECT id_sessione FROM sessioni WHERE n_sessione = "' . $id . '"';
//        $rows = DataManager::dbQuery($sql);
//        if (!empty($rows)) {
//            $sql = 'DELETE FROM variabili WHERE sessione = ' . $rows[0]['id_sessione']; 
//            DataManager::dbQuery($sql);
//        }
//        $sql = 'DELETE FROM sessioni WHERE n_sessione = "' . $id . '"';
//        DataManager::dbQuery($sql);
        
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
     * @param int $maxlifetime
     * @return int|boolean
     * @throws \Exception
     */
    public function gc(int $maxlifetime): int|false
    {
        try {
//        $sql = 'SELECT id_sessione, n_sessione FROM sessioni WHERE (NOW() - creazione) > ' . $maxlifetime;
//        $rows = DataManager::dbQuery($sql);
//        foreach ($rows as $row) {
//            $sql = 'DELETE FROM variabili WHERE sessione = ' . $row['id_sessione']; 
//            DataManager::dbQuery($sql);
//            $sql = 'DELETE FROM sessioni WHERE n_sessione = "' . $row['n_sessione'] . '"';
//            DataManager::dbQuery($sql);
//        }
        
            $counter = 0;
            foreach (glob($this->savePath . '/sess_*') as $file) {
                if (filemtime($file) + $maxlifetime < time() && file_exists($file)) {
                    $bool = unlink($file);
                    if ($bool) {
                        $counter++;
                    } else {
                        return false;
                    }
                }
            }
            return $counter;
        } catch (\Exception $e) {
            Error::printErrorInfo(__FUNCTION__, Error::debugLevel());
            throw $e;
        }
    }
    
//    public function login($utente, $password) {
//        $md5Password = md5($password);
//        $sql = 'SELECT id_utente, root FROM utenti WHERE utente = "' . $utente . '" AND password = "' . $md5Password . '"';
//        $rows = DataManager::dbQuery($sql);
//        if (!empty($rows)) {
//            $this->idUtente = $rows[0]['id_utente'];
//            $this->root = $rows[0]['root'];
//            $this->isLogged = 1;
//            $this->recordAccess($this->idUtente);
//            return true;
//        } else {
//            return false;
//        }
//    }
//    
//    public function logout() {
//        $this->idUtente = 1;
//        $this->isLogged = 0;
//    } 
//    
//    public function recordAccess($userId) {
//        if (array_key_exists('HTTP_CLIENT_IP', $_SERVER)) {
//            $ip = $_SERVER['HTTP_CLIENT_IP']; 
//        } elseif (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
//            $arrayIp = array_values(array_filter(explode(',',$_SERVER['HTTP_X_FORWARDED_FOR'])));
//            $ip = end($arrayIp);  
//        } elseif (array_key_exists('REMOTE_ADDR', $_SERVER)) { 
//            $ip = $_SERVER['REMOTE_ADDR'];          
//        } else {
//            $ip = "";
//        }        
//        $sql = 'INSERT INTO accessi (utente, ip, browser, data) VALUES (' . $userId . ', "' . $ip . '", "' . $this->browser . '", NOW())';
//        DataManager::dbQuery($sql);
//    }
//    
//    public function addUser($user, $password, $email = 'foo', $root = 'foo') {
//        $datiUtente = explode(".", $user);
//        if ($datiUtente[0] != $user) {
//            $nome = $datiUtente[0];
//            $cognome = $datiUtente[1];
//        } else {
//            $nome = "";
//            $cognome = "";
//        }
//        $md5Password = md5($password);
//        if ($email != 'foo') {
//            $userMail = $email;
//        } else {
//            $userMail = $user . '@enas.sardegna.it';
//        }
//        if ($root != 'foo') {
//            $userRoot = $root;
//        } else {
//            $userRoot = 'sitpit';            
//        }
//        $sql = 'SELECT id_utente FROM utenti WHERE utente = "' . $user . '" AND password = "' . $md5Password . '"';
//        $rows = DataManager::dbQuery($sql);
//        if (empty($rows)) {
//            $sql = 'SELECT id_utente FROM utenti WHERE utente = "' . $user . '"';
//            $rows = DataManager::dbQuery($sql);            
//            if (empty($rows)) {
//                $sql = 'INSERT INTO utenti (nome, cognome, utente, password, email, root) VALUES ("' . $nome . '", "' . $cognome . '", "' . $user . '", "' . $md5Password . '", "' . $userMail . '", "' . $userRoot . '")';
//                DataManager::dbQuery($sql);
//                $sql = 'SELECT id_utente FROM utenti WHERE utente = "' . $user . '"';
//                $rows = DataManager::dbQuery($sql);
//            } else {
//                $sql = 'UPDATE utenti SET password = "' . $md5Password . '" WHERE id_utente = "' . $rows[0]['id_utente'] . '"';
//                DataManager::dbQuery($sql);
//            }                        
//        }
//        $userId = $rows[0]['id_utente'];
//        return $userId;
//    }   
}
