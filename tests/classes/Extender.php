<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace vaniacarta74\Sourcerer\tests\classes;

use vaniacarta74\Sourcerer\Accessor;

/**
 * Description of Extender
 *
 * @author Vania
 */
class Extender extends Accessor
{
    protected $property;
    
    public function __construct($property)
    {
        $this->property = $property;
    }
}
