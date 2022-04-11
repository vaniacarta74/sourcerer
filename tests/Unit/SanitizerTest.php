<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace vaniacarta74\Sourcerer\tests\Unit;

use PHPUnit\Framework\TestCase;
use vaniacarta74\Sourcerer\api\Sanitizer;
use vaniacarta74\Sourcerer\api\Curl;

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
                'url' => 'http://localhost/source_tests/providers/sanitizerTest.php',
                'method' => 'GET',
                'params' => [
                    'file' => 'telecontrollo_classico',
                    'var_name' => 'file',
                    'filter' => null,
                    'options' => null
                ],
                'json' => false,
                'expected' => '{
                    "ok": true,
                    "response": "telecontrollo_classico"                    
                }'
            ],
        ];
        
        return $data;
    }
    
    /**
     * @group sanitizer
     * @covers \vaniacarta74\Sourcerer\api\Sanitizer::inputGet
     * @dataProvider inputGetProvider
     */    
    public function testInputGetEqual(string $url, string $method, array $params, bool $isJson, string $expected)
    {
        $query = http_build_query($params);
        
        $queryUrl = $url . '?' . $query;
        
        $actual = Curl::run($queryUrl, $method, $params, $isJson);
        
        $this->assertJsonStringEqualsJsonString($expected, $actual);
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
