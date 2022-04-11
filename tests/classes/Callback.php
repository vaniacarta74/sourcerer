<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace vaniacarta74\Sourcerer\tests\classes;

/**
 * Description of Callback
 *
 * @author adm-gfattori
 */
class Callback {
    
    public static function myStaticMethod() {
        return 'Hello World Static!';
    }
    
    public static function myStaticMethodWithParams($param) {
        return $param;
    }
    
    public function myPublicMethod() {
        return 'Hello World Public!';
    }
    
    public function myPublicMethodWithParams($param) {
        return $param;    
    }
}
