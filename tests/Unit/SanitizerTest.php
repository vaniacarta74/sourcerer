<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace vaniacarta74\Sourcerer\tests\Unit;

use PHPUnit\Framework\TestCase;
use vaniacarta74\Sourcerer\api\Sanitizer;

/**
 * Description of SanitizerTest
 *
 * @author Vania
 */
class SanitizerTest extends TestCase
{
            
    /**
     * @group Sanitizer
     * @coversNothing
     */
    public function inputGetProvider()
    {
        $data = [
            'only var name' => [
                'var_name' => 'file',
                'filter' => null,
                'options' => null,
                'expected' => 'pippo'
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group sanitizer
     * @covers \vaniacarta74\Sourcerer\api\Sanitizer::inputGet
     * @dataProvider inputGetProvider
     */    
    public function testInputGetEqual(string $var_name, ?int $filter, ?int $options, string $expected)
    {
        $actual = Sanitizer::inputGet($var_name, $filter, $options);
                
        $this->assertEqual($expected, $actual);
    }
    
    /**
     * @group sanitizer
     * @covers \vaniacarta74\Sourcerer\api\Sanitizer::inputGet
     */
    public function BenchmarkException() : void
    {
        $date = '31/02/2020';
        
        $this->expectException(\Exception::class);
        
        Sanitizer::inputGet($date);
    }   
}
